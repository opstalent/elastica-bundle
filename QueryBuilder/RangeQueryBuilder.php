<?php

namespace Opstalent\ElasticaBundle\QueryBuilder;

use Elastica\Query;

/**
 * @author Patryk Grudniewski <patgrudniewski@gmail.com>
 * @package Opstalent\ElasticaBundle
 */
class RangeQueryBuilder extends AbstractQueryBuilder
{
    /**
     * @var string $field
     */
    protected $field;

    /**
     * @var array $from
     */
    protected $from = [];

    /**
     * @var array $to
     */
    protected $to = [];

    /**
     * @param mixed $value
     * @param bool $closed
     * @return RangeQueryBuilder
     */
    public function setFrom($value, bool $closed) : RangeQueryBuilder
    {
        $quantifier = $closed ? 'lte' : 'lt';
        $this->from = [$quantifier => $value];

        return $this;
    }

    /**
     * @param mixed $value
     * @param bool $closed
     * @return RangeQueryBuilder
     */
    public function setTo($value, bool $closed) : RangeQueryBuilder
    {
        $quantifier = $closed ? 'gte' : 'gt';
        $this->to = [$quantifier => $value];

        return $this;
    }

    /**
     * @param string $field
     * @return RangeQueryBuilder
     */
    public function setField(string $field) : RangeQueryBuilder
    {
        $this->field = $field;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getQuery() : Query
    {
        $args = array_merge($this->from, $this->to);

        $this->query->getQuery()
            ->setField($this->field, $args);

        return parent::getQuery();
    }

    /**
     * {@inheritdoc}
     */
    protected function getQueryInstance() : Query\AbstractQuery
    {
        return new Query\Range();
    }
}
