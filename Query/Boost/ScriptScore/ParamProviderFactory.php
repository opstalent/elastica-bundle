<?php

namespace Opstalent\ElasticaBundle\Query\Boost\ScriptScore;

use Opstalent\ElasticaBundle\Query\Boost\ScriptScoreInterface;

/**
 * @author Patryk Grudniewski <patgrudniewski@gmail.com>
 * @package Opstalent\ElasticaBundle
 */
class ParamProviderFactory
{
    /**
     * @param ScriptScoreInterface $distribution
     * @return ParamProviderInterface
     */
    public function getInstance(ScriptScoreInterface $distribution) : ParamProviderInterface
    {
        $provider = $this->createInstance($distribution->getProviderClass());

        return $provider;
    }

    /**
     * @param string $class
     */
    private function createInstance(string $class) : ParamProviderInterface
    {
        return new $class;
    }
}

