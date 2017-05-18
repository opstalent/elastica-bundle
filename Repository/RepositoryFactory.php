<?php

namespace Opstalent\ElasticaBundle\Repository;

use Doctrine\Common\Annotations\AnnotationReader;
use FOS\ElasticaBundle\Configuration\ManagerInterface;
use FOS\ElasticaBundle\Finder\TransformedFinder;
use Opstalent\ElasticaBundle\Annotation\Entity;
use Opstalent\ElasticaBundle\Exception\MappingException;
use Opstalent\ElasticaBundle\Query\Template\ContainerResolver;
use Opstalent\ElasticaBundle\Repository\ElasticsearchRepositoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * @author Patryk Grudniewski <patgrudniewski@gmail.com>
 * @package Opstalent\ElasticaBundle
 */
class RepositoryFactory
{
    /**
     * @var AnnotationReader $annotationReader
     */
    protected $annotationReader;

    /**
     * @var ElasticsearchRepositoryInterface[]
     */
    protected $repositories = [];

    /**
     * @var ManagerInterface
     */
    protected $configManager;

    /**
     * @var ContainerInterface
     */
    protected $serviceContainer;

    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * @var ContainerResolver
     */
    protected $templateResolver;

    /**
     * @param ConfigManager $configManager
     * @param ContainerInterface $container
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(ManagerInterface $configManager, ContainerInterface $container, EventDispatcherInterface $dispatcher, ContainerResolver $resolver)
    {
        $this->annotationReader = new AnnotationReader();
        $this->configManager = $configManager;
        $this->serviceContainer = $container;
        $this->eventDispatcher = $dispatcher;
        $this->templateResolver = $resolver;
    }

    /**
     * @param string $class
     * @return ObjectRepository
     */
    public function getRepository(string $class) : ElasticsearchRepositoryInterface
    {
        if (!array_key_exists($class, $this->repositories)) {
            $repositoryClass = $this->resolveRepositoryClass(new \ReflectionClass($class));
            $finder = $this->resolveFinder($class);
            $this->repositories[$class] = new $repositoryClass($finder, $this->eventDispatcher, $this->templateResolver);
        }

        return $this->repositories[$class];
    }

    /**
     * @param string $classname
     * @return TransformedFinder
     */
    protected function resolveFinder(string $classname) : TransformedFinder
    {
        $type = null;
        $index = null;
        foreach ($this->configManager->getIndexNames() as $indexAlias) {
            $indexConfig = $this->configManager->getIndexConfiguration($indexAlias);
            foreach ($indexConfig->getTypes() as $typeAlias => $typeConfig) {
                if ($typeConfig->getModel() == $classname) {
                    $index = $indexAlias;
                    $type = $typeAlias;
                    break 2;
                }
            }
        }

        $service = sprintf('fos_elastica.finder.%s.%s', strtolower($index), strtolower($type));
        return $this->serviceContainer->get($service);
    }

    /**
     * @param \ReflectionClass $reflection
     * @return string
     * @throws MappingException
     */
    protected function resolveRepositoryClass(\ReflectionClass $reflection) : string
    {
        $annotations = $this->annotationReader->getClassAnnotations($reflection);
        foreach ($annotations as $annotation) {
            if ($annotation instanceof Entity) {
                return $annotation->repositoryClass;
            }
        }

        throw new MappingException(sprintf(
            'Class "%s" is not valid Elasticsearch repository',
            $reflection->getName()
        ));
    }
}
