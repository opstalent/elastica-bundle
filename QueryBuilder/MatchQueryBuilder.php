<?php

namespace Opstalent\ElasticaBundle\QueryBuilder;

use Elastica\Query;

/**
 * @author Patryk Grudniewski <patgrudniewski@gmail.com>
 * @package Opstalent\ElasticaBundle
 */
class MatchQueryBuilder extends AbstractQueryBuilder
{
    /**
     * @param string $field
     * @param mixed $value
     */
    public function setQuery(string $field, $value) : MatchQueryBuilder
    {
        $this->query->getQuery()->setParam($field, $value);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    protected function getQueryInstance() : Query\AbstractQuery
    {
        return new Query\Match();
    }
}
