<?php

namespace Opstalent\ElasticaBundle\Query\Boost;

/**
 * @author Patryk Grudniewski <patgrudniewski@gmail.com>
 * @package Opstalent\ElasticaBundle
 */
class QuadraticDistribution implements DistributionInterface
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
}
