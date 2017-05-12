<?php

namespace Opstalent\ElasticaBundle\Repository;

use FOS\ElasticaBundle\Finder\TransformedFinder;
use Opstalent\ApiBundle\Event\RepositoryEvent;
use Opstalent\ApiBundle\Event\RepositoryEvents;
use Opstalent\ApiBundle\Event\RepositorySearchEvent;
use Opstalent\ElasticaBundle\QueryBuilder\QueryBuilderFactory;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * @package Opstalent\ElasticaBundle
 * @author Patryk Grudniewski <patgrudniewski@gmail.com>
 */
class ElasticsearchRepository implements ElasticsearchRepositoryInterface
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
     * @param TransformedFinder $finder
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(TransformedFinder $finder, EventDispatcherInterface $dispatcher)
    {
        $this->finder = $finder;
        $this->dispatcher = $dispatcher;
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
