<?php

namespace Opstalent\ElasticaBundle\Query\Template;

use Opstalent\ElasticaBundle\Query\QueryInterface;

/**
 * @author Patryk Grudniewski <patgrudniewski@gmail.com>
 * @package Opstalent\ElasticaBundle
 */
class BoolTemplate extends AbstractTemplate
{
    /**
     * @var array
     */
    protected $should = [];

    /**
     * @var array
     */
    protected $must = [];

    /**
     * @var array
     */
    protected $mustNot = [];

    /**
     * @param AbstractTemplate $query
     */
    public function addShould(QueryInterface $query)
    {
        $this->should[] = $query;
    }

    /**
     * @return array
     */
    public function getShould() : array
    {
        return $this->should;
    }

    /**
     * @param AbstractTemplate $query
     */
    public function addMust(QueryInterface $query)
    {
        $this->must[] = $query;
    }

    /**
     * @return array
     */
    public function getMust() : array
    {
        return $this->must;
    }

    /**
     * @param AbstractTemplate $query
     */
    public function addMustNot(QueryInterface $query)
    {
        $this->mustNot[] = $query;
    }

    /**
     * @return array
     */
    public function getMustNot() : array
    {
        return $this->mustNot;
    }
}
