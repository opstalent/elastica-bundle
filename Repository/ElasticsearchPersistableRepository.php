<?php

namespace Opstalent\ElasticaBundle\Repository;

use Opstalent\ApiBundle\Repository\PersistableRepositoryInterface as PersistableRepository;
use Opstalent\ApiBundle\Repository\SearchableRepositoryInterface as SearchableRepository;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * @package Opstalent\ElasticaBundle
 * @author Patryk Grudniewski <patgrudniewski@gmail.com>
 */
class ElasticsearchPersistableRepository implements
    PersistableRepository,
    SearchableRepository,
    EventDispatcherInterface
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
     * @var EventDispatcherInterface
     */
    protected $dispatcher;

    /**
     * @param PersistableRepoistory $persistable
     * @param SearchableRepository $searchable
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(PersistableRepository $persistable, SearchableRepository $searchable, EventDispatcherInterface $dispatcher)
    {
        $this->setEventDispatcher($dispatcher);

        $this->persistableRepository = $persistable;
        $this->searchableRepository = $searchable;

        $this->persistableRepository->setEventDispatcher($this);
        $this->searchableRepository->setEventDispatcher($this);
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
    public function dispatch($eventName, Event $event = null)
    {
        $this->dispatcher->dispatch($eventName, $event);
    }

    /**
     * {@inheritdoc}
     */
    public function addListener($eventName, $listener, $priority = 0)
    {
        $this->dispatcher->addListener($eventName, $listener, $priority);
    }

    /**
     * {@inheritdoc}
     */
    public function addSubscriber(EventSubscriberInterface $subscriber)
    {
        $this->dispatcher->addSubscriber($subscriber);
    }

    /**
     * {@inheritdoc}
     */
    public function removeListener($eventName, $listener)
    {
        $this->dispatcher->removeListener($eventName, $listener);
    }

    /**
     * {@inheritdoc}
     */
    public function removeSubscriber(EventSubscriberInterface $subscriber)
    {
        $this->dispatcher->removeSubscriber($subscriber);
    }

    /**
     * {@inheritdoc}
     */
    public function getListeners($eventName = null)
    {
        return $this->dispatcher->getListeners($eventName);
    }

    /**
     * {@inheritdoc}
     */
    public function getListenerPriority($eventName, $listener)
    {
        return $this->dispatcher->getListenerPriority($eventName, $listener);
    }

    /**
     * {@inheritdoc}
     */
    public function hasListeners($eventName = null)
    {
        return $this->dispatcher->hasListeners($eventName);
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
