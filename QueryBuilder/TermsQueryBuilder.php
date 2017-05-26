<?php

namespace Opstalent\ElasticaBundle\QueryBuilder;

use Elastica\Query;

/**
 * @author Szymon Kunowski <szymon.kunowski@gmail.com>
 * @package Opstalent\ElasticaBundle
 */
class TermsQueryBuilder extends AbstractQueryBuilder
{

    /**
     * @param string $field
     * @param mixed $value
     */
    public function setQuery(string $field, $value) : TermsQueryBuilder
    {
        $this->query->getQuery()->setTerms($field, array_map('strtolower', $value));

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    protected function getQueryInstance() : Query\AbstractQuery
    {
        return new Query\Terms();
    }
}
