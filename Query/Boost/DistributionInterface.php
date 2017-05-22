<?php

namespace Opstalent\ElasticaBundle\Query\Boost;

/**
 * @author Patryk Grudniewski <patgrudniewski@gmail.com>
 * @package Opstalent\ElasticaBundle
 */
interface DistributionInterface
{
    /**
     * @return string
     */
    public function getProviderClass() : string;
}
