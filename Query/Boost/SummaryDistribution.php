<?php

namespace Opstalent\ElasticaBundle\Query\Boost;

/**
 * @author Patryk Grudniewski <patgrudniewski@gmail.com>
 * @package Opstalent\ElasticaBundle
 */
class SummaryDistribution implements DistributionInterface
{
    /**
     * @var float
     */
    protected $boost;

    /**
     * @param float $boost
     */
    public function __construct(float $boost = 1.0)
    {
        $this->boost = $boost;
    }

    /**
     * @param float $boost
     */
    public function setBoost(float $boost)
    {
        $this->boost = $boost;
    }
}
