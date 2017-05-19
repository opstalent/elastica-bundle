<?php

namespace Opstalent\ElasticaBundle\Query\Boost;

/**
 * @author Patryk Grudniewski <patgrudniewski@gmail.com>
 * @package Opstalent\ElasticaBundle
 */
abstract class CompoundDistributionProvider extends AbstractDistributionProvider
{
    /**
     * @var int
     */
    protected $count;

    /**
     * @var int
     */
    protected $iterator = 0;

    /**
     * {@inheritdoc}
     */
    final public function getValue($data) : float
    {
        return $this->calculateValue($data, $this->iterator++, $this->count);
    }

    /**
     * {@inheritdoc}
     */
    public function setDistribution(DistributionInterface $distribution)
    {
        parent::setDistribution($distribution);
        $this->reset();
    }

    public function reset()
    {
        $this->iterator = 0;
    }

    /**
     * @param int $count
     */
    public function setCount(int $count)
    {
        $this->count = $count;
        $this->reset();
    }

    /**
     * @param object $data
     * @param int $iterator
     * @param int $count
     * @return float
     */
    abstract protected function calculateValue($data, int $iterator, int $count) : float;
}
