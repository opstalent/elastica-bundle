<?php

namespace Opstalent\ElasticaBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @author Patryk Grudniewski <patgrudniewski@gmail.com>
 * @package Opstalent\ElasticaBundle
 */
class QueryScriptScoreResolverPass implements CompilerPassInterface
{
    /**
     * {@inhetitdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('ops_elastica.query.script_score_resolver_factory')) {
            return;
        }

        $definition = $container->findDefinition('ops_elastica.query.script_score_resolver_factory');
        $tagged = $container->findTaggedServiceIds('ops_elastica.query_script_score_resolver');
        foreach ($tagged as $id => $tags) {
            $definition->addMethodCall('addResolver', [new Reference($id)]);
        }
    }
}
