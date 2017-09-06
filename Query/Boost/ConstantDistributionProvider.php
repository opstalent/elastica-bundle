<?php

namespace Opstalent\ElasticaBundle\Query\Boost;

/**
 * @author Tomasz Piasecki <tpiasecki85@gmail.com>
 * @package Opstalent\ElasticaBundle
 */
class ConstantDistributionProvider extends CompoundDistributionProvider
{
    /**
     * @var float
     */
    protected $value;

    /**
     * {@inheritdoc}
     */
    protected function calculateValue($data, int $iterator, int $count) : float
    {
        return $this->value;
    }

    /**
     * {@inheritdoc}
     */
    public function setDistribution(DistributionInterface $distribution)
    {
        parent::setDistribution($distribution);
        $this->value = $this->distribution->getValue();
    }
}
