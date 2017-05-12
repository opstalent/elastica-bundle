<?php

namespace Opstalent\ElasticaBundle\Repository;

use Opstalent\ApiBundle\Repository\PersistableRepositoryInterface as PersistableRepository;

/**
 * @package Opstalent\ElasticaBundle
 * @author Patryk Grudniewski <patgrudniewski@gmail.com>
 */
class ElasticsearchPersistableRepository implements
    PersistableRepository,
    ElasticsearchRepositoryInterface
{
    /**
     * @var PersistableRepository
     */
    protected $persistableRepository;

    /**
     * @var ElasticsearchRepository
     */
    protected $searchableRepository;

    /**
     * @param PersistableRepoistory $persistable
     * @param ElasticsearchRepositoryInterface $searchable
     */
    public function __construct(PersistableRepository $persistable, ElasticsearchRepositoryInterface $searchable)
    {
        $this->persistableRepository = $persistable;
        $this->searchableRepository = $searchable;
    }

    /**
     * {@inheritdoc}
     */
    public function remove($data, bool $flush = true)
    {
        return $this->persistableRepository->remove($data, $flush);
    }

    /**
     * {@inheritdoc}
     */
    public function flush()
    {
        $this->persistableRepository->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function persist($data, bool $flush = false)
    {
        return $this->persistableRepository->persist($data, $flush);
    }

    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        return $this->persistableRepository->find($id);
    }

    /**
     * {@inheritdoc}
     */
    public function findAll()
    {
        return $this->persistableRepository->findAll();
    }

    /**
     * {@inheritdoc}
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->persistableRepository->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * {@inheritdoc}
     */
    public function findOneBy(array $criteria)
    {
        return $this->persistableRepository->findOneBy($criteria);
    }

    /**
     * {@inheritdoc}
     */
    public function getClassName()
    {
        return $this->persistableRepository->getClassName();
    }

    /**
     * {@inheritdoc}
     */
    public function setLimit(int $limit)
    {
        $this->searchableRepository->setLimit($limit);
    }

    /**
     * {@inheritdoc}
     */
    public function setOffset(int $offset)
    {
        $this->searchableRepository->setOffset($offset);
    }

    /**
     * {@inheritdoc}
     */
    public function setOrder(string $order, string $orderBy)
    {
        $this->searchableRepository->setOrder($order, $orderBy);
    }

    /**
     * {@inheritdoc}
     */
    public function searchByFilters(array $data) : array
    {
        return $this->searchableRepository->searchByFilters($data);
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters() : array
    {
        return $this->searchableRepository->getFilters();
    }

    /**
     * {@inheritdoc}
     */
    public function getEntityName() : string
    {
        return $this->persistableRepository->getEntityName();
    }
}
