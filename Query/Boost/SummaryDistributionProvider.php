<?php

namespace Opstalent\ElasticaBundle\Query\Boost;

/**
 * @author Patryk Grudniewski <patgrudniewski@gmail.com>
 * @package Opstalent\ElasticaBundle
 */
class SummaryDistributionProvider extends CompoundDistributionProvider
{
    /**
     * {@inheritdoc}
     */
    protected function calculateValue($data, int $iterator, int $count) : float
    {
        return $this->boostPool / $count;
    }
}
