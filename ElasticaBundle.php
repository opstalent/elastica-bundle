<?php

namespace Opstalent\ElasticaBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * @package Opstalent\ElasticaBundle
 * @author Patryk Grudniewski <patgrudniewski@gmail.com>
 */
class ElasticaBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container
            ->addCompilerPass(new DependencyInjection\Compiler\QueryTemplateResolverPass())
            ->addCompilerPass(new DependencyInjection\Compiler\QueryScriptScoreResolverPass())
            ;
    }
}
