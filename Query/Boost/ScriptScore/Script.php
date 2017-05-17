<?php

namespace Opstalent\ElasticaBundle\Query\Boost\ScriptScore;

use Opstalent\ElasticaBundle\Query\Boost\ScriptScoreInterface;

/**
 * @author Patryk Grudniewski <patgrudniewski@gmail.com>
 * @package Opstalent\ElasticaBundle
 */
class Script implements ScriptScoreInterface
{
    /**
     * @var string
     */
    protected $provider;

    /**
     * @var string
     */
    protected $inline;

    /**
     * @param string $providerClass
     */
    public function __construct(string $providerClass, string $inline)
    {
        if (!is_subclass_of($providerClass, ParamProviderInterface::class)) {
            throw new \InvalidArgumentException(sprintf(
                'Script param provider class is expected to be instance of "%s"',
                ParamProviderInterface::class
            ));
        }

        $this->provider = $providerClass;
        $this->inline = $inline;
    }
}
