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
     * @param AbstractTemplate $query
     */
    public function addShould(AbstractTemplate $query)
    {
        $this->should[] = $query;
    }

    /**
     * @return array
     */
    public function getShould()
    {
        return $this->should;
    }
}
