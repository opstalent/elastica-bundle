<?php

namespace Opstalent\ElasticaBundle\Query\Template;

use Opstalent\ElasticaBundle\Query\Boost\ScriptScore\ResolverFactory;

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
     * @var ResolverFactory
     */
    protected $scriptScoreResolverFactory;

    /**
     * @param TemplateResolverFactory $tFactory
     * @param ResolverFactory $srciptScoreFactory
     */
    public function __construct(TemplateResolverFactory $templateFactory, ResolverFactory $scriptScoreFactory)
    {
        $this->templateResolverFactory = $templateFactory;
        $this->scriptScoreResolverFactory = $scriptScoreFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function resolve(AbstractTemplate $template, $data, array $mapping = []) : array
    {
        $query = $template->getQuery();
        if ($query instanceof AbstractTemplate) {
            $templateResolver = $this->templateResolverFactory->getInstance($query);
            $query = $templateResolver->resolve($query, $data, $mapping);
        } else {
            $query = $query->getQuery();
        }

        $scriptScoreResolver = $this->scriptScoreResolverFactory->getInstance($template->getScriptScore());

        $query = [
            'function_score' => [
                'query' => $query,
                'script_score' => $scriptScoreResolver->resolve($template->getScriptScore(), $data),
                'boost' => $template->getBoost(),
            ],
        ];

        if (null !== $template->getMinimumScore()) {
            $query['function_score']['min_score'] = $template->getMinimumScore();
        }
        if (null !== $template->getBoostMode()) {
            $query['function_score']['boost_mode'] = $template->getBoostMode();
        }

        return $query;
    }
}
