<?php

namespace Opstalent\ElasticaBundle\Query\Template;

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
     * @param AbstractTemplate $query
     */
    public function addShould(AbstractTemplate $query)
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
    public function addMust(AbstractTemplate $query)
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
}
