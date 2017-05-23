<?php

namespace Opstalent\ElasticaBundle\Model;

/**
 * @author Patryk Grudniewski <patgrudniewski@gmail.com>
 * @package Opstalent\ElasticaBundle
 */
interface ScorableInterface
{
    /**
     * @param float $score
     * @return ScorableInterface
     */
    public function setScore(float $score) : ScorableInterface;
}
