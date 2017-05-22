<?php

namespace Opstalent\ElasticaBundle\Query\Boost;

/**
 * @author Patryk Grudniewski <patgrudniewski@gmail.com>
 * @package Opstalent\ElasticaBundle
 */
class QuadraticDistribution extends AbstractDistribution
{
    /**
     * @var float
     */
    protected $from;

    /**
     * @var float
     */
    protected $to;

    /**
     * @param float $from
     * @param float $to
     * @throws \InvalidArgumentException
     */
    public function __construct(float $from, float $to)
    {
        if ($from >= $to) {
            throw new \InvalidArgumentException('QuadraticDistribution x-axis minimum value is not lower than maximum value');
        }

        $this->from = $from;
        $this->to = $to;
    }

    /**
     * @return float
     */
    public function getFrom() : float
    {
        return $this->from;
    }

    /**
     * @return float
     */
    public function getTo() : float
    {
        return $this->to;
    }
}
