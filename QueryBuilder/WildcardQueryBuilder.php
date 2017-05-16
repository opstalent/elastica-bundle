<?php

namespace Opstalent\ElasticaBundle\QueryBuilder;

use Elastica\Query;

/**
 * @author Patryk Grudniewski <patgrudniewski@gmail.com>
 * @package Opstalent\ElasticaBundle
 */
class WildcardQueryBuilder extends AbstractQueryBuilder
{
    /**
     * @param string $field
     * @param string $match
     * @return WildcardQueryBuilder
     */
    public function setQuery(string $field, string $match) : WildcardQueryBuilder
    {
        $this->query->getQuery()
            ->setValue($field, strtolower($match));

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    protected function getQueryInstance() : Query\AbstractQuery
    {
        return new Query\Wildcard();
    }
}
