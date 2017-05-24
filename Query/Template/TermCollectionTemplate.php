<?php

namespace Opstalent\ElasticaBundle\Query\Template;

use Opstalent\ElasticaBundle\Query\Boost\DistributionInterface as Distribution;

/**
 * @author Patryk Grudniewski <patgrudniewski@gmail.com>
 * @package Opstalent\ElasticaBundle
 */
class TermCollectionTemplate extends TermsTemplate implements CollectionTemplateInterface
{
    /**
     * @var Distribution $dist
     */
    protected $dist;

    /**
     * @param Distribution $dist
     * {@inheritdoc}
     */
    public function __construct(string $source, string $field, Distribution $dist, float $boost = 1.0)
    {
        parent::__construct($source, $field, $boost);

        $this->distribution = $dist;
    }

    /**
     * @return Distribution
     */
    public function getDistribution() : Distribution
    {
        return $this->distribution;
    }
}
