<?php

namespace Opstalent\ElasticaBundle\Query\Template;

use Opstalent\ElasticaBundle\Query\Query;

/**
 * @author Patryk Grudniewski <patgrudniewski@gmail.com>
 * @package Opstalent\ElasticaBundle
 */
class ContainerResolver
{
    /**
     * @var TemplateResolverFactory
     */
    protected $resolverFactory;

    /**
     * @param TemplateResolverFactory $factory
     */
    public function __construct(TemplateResolverFactory $factory)
    {
        $this->resolverFactory = $factory;
    }

    /**
     * @param Container $container
     * @param object $data
     * @return Query
     */
    public function resolve(Container $container, $data, array $mapping = []) : Query
    {
        $template = $container->getQueryTemplate();
        $query = [
            'query' => $this->resolverFactory->getInstance($template)->resolve($template, $data, $mapping),
        ];

        $minScore = $container->getMinimumScore();
        if (null !== $minScore) {
            $query['min_score'] = $minScore;
        }

        return new Query($query);
    }

}
