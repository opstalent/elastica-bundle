<?php

namespace Opstalent\ElasticaBundle\Query\Boost;

/**
 * @author Patryk Grudniewski <patgrudniewski@gmail.com>
 * @package Opstalent\ElasticaBundle
 */
class DistributionProviderFactory
{
    /**
     * @param DistributionInterface $distribution
     * @return AbstractDistributionProvider
     */
    public function getInstance(DistributionInterface $distribution) : AbstractDistributionProvider
    {
        $provider = $this->createInstance($distribution->getProviderClass());
        $provider->setDistribution($distribution);

        return $provider;
    }

    /**
     * @param string $class
     * @return AbstractDistributionProvider
     */
    private function createInstance(string $class) : AbstractDistributionProvider
    {
        return new $class;
    }
}
