<?php

namespace Opstalent\ElasticaBundle\Query\Boost\ScriptScore;

/**
 * @author Patryk Grudniewski <patgrudniewski@gmail.com>
 * @package Opstalent\ElasticaBundle
 */
class EmptyParamProvider implements ParamProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function getParameters($data) : array
    {
        return [];
    }
}
