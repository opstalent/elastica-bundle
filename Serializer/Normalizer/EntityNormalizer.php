<?php

namespace Opstalent\ElasticaBundle\Serializer\Normalizer;

use Opstalent\ElasticaBundle\Exception\MappingException;
use Opstalent\ElasticaBundle\Repository\ElasticsearchRepositoryInterface as Repository;
use Opstalent\ElasticaBundle\Repository\RepositoryFactory;
use Opstalent\ElasticaBundle\Transformer\MapTransformer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 * @author Patryk Grudniewski <patgrudniewski@gmail.com>
 * @package Opstalent\ElasticaBundle
 */
class EntityNormalizer extends ObjectNormalizer
{
    /**
     * @var RepositoryFactory
     */
    protected $repositoryFactory;

    /**
     * @param RepositoryFactory $factory
     */
    public function __construct(RepositoryFactory $factory)
    {
        parent::__construct();

        $this->repositoryFactory = $factory;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null)
    {
        return parent::supportsNormalization($data, $format) && $this->supports(get_class($data));
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return parent::supportsDenormalization($data, $type, $format) && $this->supports($type);
    }

    /**
     * {@inheritdoc}
     */
    public function normalize($object, $format = null, array $context = [])
    {
        $data = parent::normalize($object, $format, $context);
        if (null === $data) {
            return $data;
        }

        $repository = $this->repositoryFactory->getRepository(get_class($object));
        $mapper = new MapTransformer($repository->getFieldsMapping());

        return array_combine($mapper->transform(array_keys($data)), $data);
    }

    /**
     * {@inheritdoc}
     */
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        if (null !== $data) {
            $repository = $this->repositoryFactory->getRepository($class);
            $mapper = new MapTransformer($repository->getFieldsMapping());

            $data = array_combine($mapper->reverseTransform(array_keys($data)), $data);
        }

        return parent::denormalize($data, $class, $format, $context);
    }

    /**
     * @param string $classname
     * @return bool
     */
    private function supports(string $classname) : bool
    {
        try {
            return $this->repositoryFactory->getRepository($classname) instanceof Repository;
        } catch (MappingException $e) {
            return false;
        }
    }
}
