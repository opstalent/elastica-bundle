<?php

namespace Opstalent\ElasticaBundle\Repository;

use Elastica\Query;
use FOS\ElasticaBundle\Finder\TransformedFinder;
use FOS\ElasticaBundle\Repository;
use Opstalent\ApiBundle\Event\RepositoryEvent;
use Opstalent\ApiBundle\Event\RepositoryEvents;
use Opstalent\ApiBundle\Event\RepositorySearchEvent;
use Opstalent\ApiBundle\Repository\SearchableRepositoryInterface;
use Opstalent\ElasticaBundle\Exception\DocumentNotFoundException;
use Opstalent\ElasticaBundle\Query\TemplateBuilder;
use Opstalent\ElasticaBundle\Query\Template\ContainerResolver;
use Opstalent\ElasticaBundle\QueryBuilder\CompoundQueryBuilder;
use Opstalent\ElasticaBundle\QueryBuilder\QueryBuilderFactory;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * @package Opstalent\ElasticaBundle
 * @author Patryk Grudniewski <patgrudniewski@gmail.com>
 */
class ElasticsearchRepository extends Repository implements ElasticsearchRepositoryInterface
{
    /**
     * @var array
     */
    protected $filters = [];

    /**
     * @var string
     */
    protected $entityName = '';

    /**
     * @var TransformedFinder
     */
    protected $finder;

    /**
     * @var EventDispatcherInterface
     */
    protected $dispatcher;

    /**
     * @var array
     */
    protected $mapping = [];

    /**
     * @var ContainerResolver
     */
    protected $templateResolver;

    /**
     * @var array
     */
    private $templates = [];

    /**
     * {@inheritdoc}
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(TransformedFinder $finder, EventDispatcherInterface $dispatcher, ContainerResolver $resolver)
    {
        parent::__construct($finder);

        $this->templateResolver = $resolver;

        $this->setEventDispatcher($dispatcher);
    }

    /**
     * @param Query $query
     * @param array $options
     * @return object
     * @throws DocumentNotFoundException
     */
    public function findOne(Query $query, array $options = [])
    {
        $result = $this->find($query, 1, $options);
        if (!count($result)) {
            throw new DocumentNotFoundException($this->entityName, $query);
        }

        return $result[0];
    }

    /**
     * @param CompoundQueryBuilder $qb
     * @param string $template
     * @param object $data
     */
    public function extendQueryFromTemplate(CompoundQueryBuilder $qb, string $template, $data)
    {
        $query = $this->templateResolver->resolve($this->templates[$template], $data, $this->getFieldsMapping());
        $qb->merge($query);
    }

    /**
     * @param string $templateName
     * @param array $template
     */
    public function setQueryTemplate(string $templateName, array $template)
    {
        $template = TemplateBuilder::fromArray($template);
        $this->templates[$templateName] = $template;
    }

    /**
     * {@inheritdoc}
     */
    public function setEventDispatcher(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * {@inheritdoc}
     */
    public function getFieldsMapping() : array
    {
        return $this->mapping;
    }

    /**
     * {@inheritdoc}
     */
    public function searchByFilters(array $data) : array
    {
        $qb = QueryBuilderFactory::create('bool');

        $this->dispatchEvent(new RepositorySearchEvent(
            RepositoryEvents::BEFORE_SEARCH_BY_FILTER,
            $this,
            $data,
            $qb
        ));

        $result = [];
        if (array_key_exists('count', $data)) {
            $result['list'] = $this->finder->findPaginated($qb->getQuery());
            $result['total'] = count($result['list']);

            unset($data['count']);
        } else {
            $result['list'] = $this->finder->find($qb->getQuery());
        }

        return $result;
    }

    /**
     * @param RepositoryEvent $event
     */
    protected function dispatchEvent(RepositoryEvent $event)
    {
        $this->dispatcher->dispatch($event->getName(), $event);
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters() : array
    {
        return $this->filters;
    }

    /**
     * {@inheritdoc}
     */
    public function getEntityName() : string
    {
        return $this->entityName;
    }
}
