<?php

namespace Opstalent\ElasticaBundle\Query\Template;

use Opstalent\ElasticaBundle\Query\QueryInterface;

/**
 * @author Patryk Grudniewski <patgrudniewski@gmail.com>
 * @package Opstalent\ElasticaBundle
 */
abstract class AbstractTemplate implements QueryInterface
{
    /**
     * @var float
     */
    protected $boost;

    /**
     * @param float $boost
     */
    public function __construct(float $boost = 1.0)
    {
        $this->boost = $boost;
    }

    /**
     * @param float $boost
     */
    public function setBoost(float $boost)
    {
        $this->boost = $boost;
    }

    /**
     * @return float
     */
    public function getBoost() : float
    {
        return $this->boost;
    }

    /**
     * @return string
     */
    public function getResolverClass() : string
    {
        return static::class . 'Resolver';
    }
}
