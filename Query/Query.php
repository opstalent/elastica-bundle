<?php

namespace Opstalent\ElasticaBundle\Query;

/**
 * @author Patryk Grudniewski <patgrudniewski@gmail.com>
 * @package Opstalent\ElasticaBundle
 */
class Query implements QueryInterface
{
    /**
     * @var array
     */
    protected $query;

    /**
     * @param array $query
     */
    public function __construct(array $query)
    {
        $this->query = $query;
    }

    /**
     * @return array
     */
    public function getQuery() : array
    {
        return $this->query;
    }
}
