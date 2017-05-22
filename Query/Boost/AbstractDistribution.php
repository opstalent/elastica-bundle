<?php

namespace Opstalent\ElasticaBundle\Query\Boost;

/**
 * @author Patryk Grudniewski <patgrudniewski@gmail.com>
 * @package Opstalent\ElasticaBundle
 */
abstract class AbstractDistribution implements DistributionInterface
{
    /**
     * {@inheritdoc}
     */
    public function getProviderClass() : string
    {
        return static::class . 'Provider';
    }
}
