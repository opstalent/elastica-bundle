<?php

namespace Opstalent\ElasticaBundle\Query\Template;

/**
 * @author Patryk Grudniewski <patgrudniewski@gmail.com>
 * @package Opstalent\ElasticaBundle
 */
class DisMaxTemplate extends AbstractTemplate
{
    /**
     * @var array
     */
    protected $subqueries = [];

    /**
     * @param AbstractTemplate $query
     */
    public function addSubquery(AbstractTemplate $query)
    {
        $this->subqueries[] = $query;
    }

    /**
     * @return array
     */
    public function getSubqueries() : array
    {
        return $this->subqueries;
    }
}
