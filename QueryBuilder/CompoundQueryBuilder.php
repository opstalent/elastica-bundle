<?php

namespace Opstalent\ElasticaBundle\QueryBuilder;

use Opstalent\ApiBundle\QueryBuilder\QueryBuilderInterface;

/**
 * @package Opstalent\ElasticaBundle
 * @author Patryk Grudniewski <patgrudniewski@gmail.com>
 */
abstract class CompoundQueryBuilder extends AbstractQueryBuilder implements QueryBuilderInterface
{
    /**
     * @return AbstractQueryBuilder
     */
    public function inner() : AbstractQueryBuilder
    {
        return $this;
    }
}
