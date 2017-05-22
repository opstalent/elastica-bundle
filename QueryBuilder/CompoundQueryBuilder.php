<?php

namespace Opstalent\ElasticaBundle\QueryBuilder;

use Opstalent\ApiBundle\QueryBuilder\QueryBuilderInterface;
use Opstalent\ElasticaBundle\Query\Query;

/**
 * @package Opstalent\ElasticaBundle
 * @author Patryk Grudniewski <patgrudniewski@gmail.com>
 */
abstract class CompoundQueryBuilder extends AbstractQueryBuilder implements QueryBuilderInterface
{
    /**
     * @param Query $query
     * @return CompoundQueryBuilder
     */
    abstract public function merge(Query $query) : CompoundQueryBuilder;

    /**
     * @return AbstractQueryBuilder
     */
    public function inner() : AbstractQueryBuilder
    {
        return $this;
    }
}
