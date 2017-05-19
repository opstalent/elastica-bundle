<?php

namespace Opstalent\ElasticaBundle\Query\Boost\ScriptScore;

use Opstalent\ElasticaBundle\Query\Boost\ScriptScoreInterface;

/**
 * @author Patryk Grudniewski <patgrudniewski@gmail.com>
 * @package Opstalent\ElasticaBundle
 */
interface ResolverInterface
{
    /**
     * @param ScriptScoreInterface $score
     * @param object $data
     * @return array
     */
    public function resolve(ScriptScoreInterface $score, $data) : array;
}
