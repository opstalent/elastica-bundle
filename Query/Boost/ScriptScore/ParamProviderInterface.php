<?php

namespace Opstalent\ElasticaBundle\Query\Boost\ScriptScore;

/**
 * @author Patryk Grudniewski <patgrudniewski@gmail.com>
 * @package Opstalent\ElasticaBundle
 */
interface ParamProviderInterface
{
    /**
     * @param object $data
     * @return array
     */
    public function getParameters($data) : array;
}
