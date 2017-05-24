<?php

namespace Opstalent\ElasticaBundle\Query\Boost\ScriptScore;

use Opstalent\ElasticaBundle\Query\Boost\ScriptScoreInterface;

/**
 * @author Patryk Grudniewski <patgrudniewski@gmail.com>
 * @package Opstalent\ElasticaBundle
 */
class ScriptResolver implements ResolverInterface
{
    /**
     * @var ParamProviderFactory
     */
    protected $providerFactory;

    /**
     * @param ParamProviderFactory
     */
    public function __construct(ParamProviderFactory $factory)
    {
        $this->providerFactory = $factory;
    }

    /**
     * {@inheritdoc}
     */
    public function resolve(ScriptScoreInterface $score, $data) : array
    {
        $provider = $this->providerFactory->getInstance($score);

        return [
            'script' => [
                'params' => (object) $provider->getParameters($data),
                'inline' => $score->getInline(),
            ],
        ];
    }
}
