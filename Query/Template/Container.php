<?php

namespace Opstalent\ElasticaBundle\Query\Template;

/**
 * @author Patryk Grudniewski <patgrudniewski@gmail.com>
 * @package Opstalent\ElasticaBundle
 */
class Container
{
    /**
     * @var AbstractTemplate
     */
    protected $query;

    /**
     * @var float
     */
    protected $minimumScore;

    /**
     * @param AbstractTemplate $query
     */
    public function __construct(AbstractTemplate $query)
    {
        $this->query = $query;
    }

    /**
     * @param float $score
     */
    public function setMinimumScore(float $score)
    {
        $this->minimumScore = $score;
    }

    /**
     * @return float|null
     */
    public function getMinimumScore()
    {
        return $this->minimumScore;
    }

    /**
     * @return AbstractTemplate
     */
    public function getQueryTemplate() : AbstractTemplate
    {
        return $this->query;
    }
}
