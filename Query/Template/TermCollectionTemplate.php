<?php

namespace Opstalent\ElasticaBundle\Query\Template;

use Opstalent\ElasticaBundle\Query\Boost\DistributionInterface as Distribution;

/**
 * @author Patryk Grudniewski <patgrudniewski@gmail.com>
 * @package Opstalent\ElasticaBundle
 */
class TermCollectionTemplate extends AbstractTemplate implements CollectionTemplateInterface
{
    /**
     * @var string
     */
    protected $source;

    /**
     * @var string
     */
    protected $field;

    /**
     * @var Distribution $dist
     */
    protected $dist;

    /**
     * @param string $source
     * @param string $field
     * @param Distribution $dist
     * {@inheritdoc}
     */
    public function __construct(string $source, string $field, Distribution $dist, float $boost = 1.0)
    {
        parent::__construct($boost);

        $this->source = $source;
        $this->field = $field;
        $this->distribution = $dist;
    }

    /**
     * @return string
     */
    public function getSource() : string
    {
        return $this->source;
    }

    /**
     * @return string
     */
    public function getField() : string
    {
        return $this->field;
    }

    /**
     * @return Distribution
     */
    public function getDistribution() : Distribution
    {
        return $this->distribution;
    }
}