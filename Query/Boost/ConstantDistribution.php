<?php

namespace Opstalent\ElasticaBundle\Query\Boost;

/**
 * @author Tomasz Piasecki <tpiasecki85@gmail.com>
 * @package Opstalent\ElasticaBundle
 */
class ConstantDistribution extends AbstractDistribution
{
    /**
     * @var float
     */
    protected $value;

    /**
     * @param float $value
     */
    public function __construct(float $value)
    {
        $this->value = $value;
    }

    /**
     * @return float
     */
    public function getValue() : float
    {
        return $this->value;
    }
}
