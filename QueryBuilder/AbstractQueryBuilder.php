<?php

namespace Opstalent\ElasticaBundle\QueryBuilder;

use Elastica\Query;
use Opstalent\ApiBundle\QueryBuilder\QueryBuilderInterface;

/**
 * @package Opstalent\ElasticaBundle
 * @author Patryk Grudniewski <patgrudniewski@gmail.com>
 */
abstract class AbstractQueryBuilder implements QueryBuilderInterface
{
    /**
     * @var Query
     */
    protected $query;

    public function __construct()
    {
        $this->query = Query::create($this->getQueryInstance());
    }

    /**
     * {@inheritdoc}
     */
    public function setLimit(int $limit)
    {
        $this->query
            ->setSize($limit);
    }

    /**
     * {@inheritdoc}
     */
    public function setOffset(int $offset)
    {
        $this->query
            ->setFrom($offset);
    }

    /**
     * {@inheritdoc}
     */
    public function setOrder(string $order, string $orderBy)
    {
        $this->query
            ->setSort([$orderBy => $order]);
    }

    /**
     * @return Query
     */
    public function getQuery() : Query
    {
        return $this->query;
    }

    /**
     * @return Query\AbstractQuery
     */
    abstract protected function getQueryInstance() : Query\AbstractQuery;
}
