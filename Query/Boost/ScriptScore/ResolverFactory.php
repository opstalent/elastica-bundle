<?php

namespace Opstalent\ElasticaBundle\Query\Boost\ScriptScore;

use Opstalent\ElasticaBundle\Query\Boost\ScriptScoreInterface;

/**
 * @author Patryk Grudniewski <patgrudniewski@gmail.com>
 * @package Opstalent\ElasticaBundle
 */
class ResolverFactory
{
    /**
     * @param array
     */
    private $instances = [];

    /**
     * @param ScriptScoreInterface $score
     * @return AbstractResolver
     */
    public function getInstance(ScriptScoreInterface $score) : ResolverInterface
    {
        $resolverClass = $score->getResolverClass();
        if (!array_key_exists($resolverClass, $this->instances)) {
            $this->createInstance($resolverClass);
        }

        return $this->instances[$resolverClass];
    }

    /**
     * @param ResolverInterface $resolver
     */
    public function addResolver(ResolverInterface $resolver)
    {
        $this->instances[get_class($resolver)] = $resolver;
    }

    /**
     * @param string $class
     */
    private function createInstance(string $class)
    {
        $this->addResolver(new $class);
    }
}
