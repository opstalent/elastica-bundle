<?php

namespace Opstalent\ElasticaBundle\Query\Template;

/**
 * @author Patryk Grudniewski <patgrudniewski@gmail.com>
 * @package Opstalent\ElasticaBundle
 */
class FunctionScoreTemplateResolver implements TemplateResolverInterface
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
     * {@inheritdoc}
     */
    public function resolve(AbstractTemplate $template, $data, array $mapping = []) : array
    {
        $query = $template->getQuery();
        if ($query instanceof AbstractTemplate) {
            $resolver = $this->resolverFactory->getInstance($query);
            $query = $resolver->resolve($query, $data, $mapping);
        } else {
            $query = $query->getQuery();
        }

        return [
            'query' => $query,
        ];
    }
}
