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
                $match = new Query\Match($field, $value);
                $this->addMust($match);
                break;
        }
    }

    /**
     * @param Query\AbstractQuery $query
     */
    public function addMust(Query\AbstractQuery $query)
    {
        $this->query->getQuery()
            ->addMust($query);
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
        $wildcard = new Query\Wildcard($field, '*' . strtolower($value) . '*');
        $this->addMust($wildcard);
    }

    /**
     * @param string $field
     * @param \DateTime $value
     */
    protected function datetimeFilter(string $field, \DateTime $value)
    {
        $value = $value->format('Y-m-d\TH:i:s');
        $range = new Query\Range($field, [
            'lt' => $value . '||+1m/m',
            'gte' => $value . '||/m',
        ]);
        
        $this->addMust($range);
    }
}
