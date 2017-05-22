<?php

namespace Opstalent\ElasticaBundle\Query\Boost;

/**
 * @author Patryk Grudniewski <patgrudniewski@gmail.com>
 * @package Opstalent\ElasticaBundle
 */
abstract class AbstractDistributionProvider
{
    /**
     * @var DistributionInterface
     */
    protected $distribution;

    /**
     * @param object $data
     * @return float
     */
    abstract public function getValue($data) : float;

    /**
     * @param DistributionInterface $distribution
     */
    public function setDistribution(DistributionInterface $distribution)
    {
        $this->distribution = $distribution;
    }
}
