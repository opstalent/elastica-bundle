<?php

namespace Opstalent\ElasticaBundle\Query\Boost;

/**
 * @author Patryk Grudniewski <patgrudniewski@gmail.com>
 * @package Opstalent\ElasticaBundle
 */
interface ScriptScoreInterface extends DistributionInterface
{
    /**
     * @return string
     */
    public function getType() : string;

    /**
     * @return string
     */
    public function getResolverClass() : string;
}
