<?php

namespace Opstalent\ElasticaBundle\QueryBuilder;

use Elastica\Query;

/**
 * @package Opstalent\ElasticaBundle
 * @author Patryk Grudniewski <patgrudniewski@gmail.com>
 */
class TermQueryBuilder extends AbstractQueryBuilder
{
    /**
     * @var string
     */
    protected $field;

    /**
     * @var mixed
     */
    protected $value;

    /**
     * @var float
     */
    protected $boost;

    /**
     * @param string $field
     * @return TermQueryBuilder
     */
    public function setField(string $field) : TermQueryBuilder
    {
        $this->field = $field;
        return $this;
    }

    /**
     * @param mixed $value
     * @return TermQueryBuilder
     */
    public function setValue($value) : TermQueryBuilder
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @param float $boost
     * @return TermQueryBuilder
     */
    public function setBoost(float $boost) : TermQueryBuilder
    {
        $this->boost = $boost;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getQuery() : Query
    {
        $this->query->getQuery()
            ->setTerm($this->field, $this->value, $this->boost)
            ;

        return parent::getQuery();
    }

    /**
     * {@inheritdoc}
     */
    protected function getQueryInstance() : Query\AbstractQuery
    {
        return new Query\Term();
    }
}
