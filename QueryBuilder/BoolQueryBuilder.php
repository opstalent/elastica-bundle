<?php

namespace Opstalent\ElasticaBundle\QueryBuilder;

use Elastica\Query;

/**
 * @package Opstalent\ElasticaBundle
 * @author Patryk Grudniewski <patgrudniewski@gmail.com>
 */
class BoolQueryBuilder extends CompoundQueryBuilder
{
    /**
     * {@inheritdoc}
     */
    public function filter(string $field, string $type, $value)
    {
        switch($type) {
            case 'string':
                $this->wildcardStringFilter($field, $value);
                break;
            case 'datetime':
                $this->datetimeFilter($field, $value);
                break;
            default:
                $match = QueryBuilderFactory::create('match')
                    ->setQuery($field, $value);
                $this->addMust($match->getQuery());
                break;
        }
    }

    /**
     * @param Query $query
     */
    public function addMust(Query $query) : BoolQueryBuilder
    {
        $this->query->getQuery()
            ->addMust($query->getQuery());

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    protected function getQueryInstance() : Query\AbstractQuery
    {
        return new Query\BoolQuery();
    }

    /**
     * @param string $field
     * @param string $value
     */
    protected function wildcardStringFilter(string $field, string $value)
    {
        $wildcard = QueryBuilderFactory::create('wildcard')
            ->setQuery($field, '*' . $value . '*');

        $this->addMust($wildcard->getQuery());
    }

    /**
     * @param string $field
     * @param \DateTime $value
     */
    protected function datetimeFilter(string $field, \DateTime $value)
    {
        $value = $value->format('Y-m-d\TH:i:s');
        $rande = QueryBuilderFactory::create('range')
            ->setField($field)
            ->setFrom($value . '||+1m/m', false)
            ->setTo($vale . '||/m', true)
            ;

        $range = new Query\Range($field, [
            'lt' => $value . '||+1m/m',
            'gte' => $value . '||/m',
        ]);
        
        $this->addMust($range);
    }
}
