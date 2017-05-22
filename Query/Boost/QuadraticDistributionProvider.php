<?php

namespace Opstalent\ElasticaBundle\Query\Boost;

/**
 * @author Patryk Grudniewski <patgrudniewski@gmail.com>
 * @package Opstalent\ElasticaBundle
 */
class QuadraticDistributionProvider extends CompoundDistributionProvider
{
    /**
     * @var float
     */
    protected $range;

    /**
     * @var float
     */
    protected $from;

    /**
     * @var float
     */
    protected $to;

    /**
     * {@inheritdoc}
     */
    public function setDistribution(DistributionInterface $distribution)
    {
        parent::setDistribution($distribution);

        $this->from = $this->distribution->getFrom();
        $this->to = $this->distribution->getTo();

        if ($this->to != 1) {
            $this->from /= $this->to;
            $this->to /= $this->to;
        }

        $this->range = $this->to - $this->from;
    }

    /**
     * {@inheritdoc}
     */
    protected function calculateValue($data, int $iterator, int $count) : float
    {
        $x = $this->to - $this->range * $iterator / ($count - 1);
        return pow($x, 2);
    }
}
