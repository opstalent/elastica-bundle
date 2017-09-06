<?php

namespace Opstalent\ElasticaBundle\Query;

use Opstalent\ElasticaBundle\Exception\InvalidTemplateDefinitionException;

/**
 * @author Patryk Grudniewski <patgrudniewski@gmail.com>
 * @package Opstalent\ElasticaBundle
 *
 * @TODO: use Symfony\OptionsResolver for parameters
 * @TODO: or Symfony\DependencyInjection configuration builder
 */
class TemplateBuilder
{
    /**
     * @param array
     * @return Template\Container
     * @throws InvalidTemplateDefinitionException
     */
    public static function fromArray(array $source) : Template\Container
    {
        if (!array_key_exists('query', $source)) {
            throw new InvalidTemplateDefinitionException('Query not defined');
        }

        $query = static::resolveQuery($source['query']);

        $template = new Template\Container($query);
        if (array_key_exists('min_score', $source)) {
            $template->setMinimumScore($source['min_score']);
        }

        return $template;
    }

    /**
     * @param array $source
     * @return QueryInterface
     * @throws InvalidTemplateDefinitionException
     */
    private static function resolveQuery(array $source) : QueryInterface
    {
        if (!array_key_exists('type', $source)) {
            throw new InvalidTemplateDefinitionException('Query type not defined');
        }

        $type = $source['type'];
        switch ($type) {
            case 'bool':
                $query = static::resolveBoolQuery($source);
                break;
            case 'dis_max':
                $query = static::resolveDisMaxQuery($source);
                break;
            case 'term':
                $query = static::resolveTermQuery($source);
                break;
            case 'terms':
                $query = static::resolveTermsQuery($source);
                break;
            case 'term_collection':
                $query = static::resolveTermCollectionQuery($source);
                break;
            case 'subitem_term':
                $query = static::resolveSubitemTermQuery($source);
                break;
            case 'subitem_term_collection':
                $query = static::resolveSubitemTermCollectionQuery($source);
                break;
            case 'function_score':
                $query = static::resolveFunctionScoreQuery($source);
                break;
            case 'parameterized_query_collection':
                $query = static::resolveParameterizedQueryCollectionQuery($source);
                break;
            case 'query':
                if (!array_key_exists('query', $source)) {
                    throw new InvalidTemplateDefinitionException('Query data not defined');
                }
                $query = new Query($source['query']);
                break;
            default:
                throw new InvalidTemplateDefinitionException(sprintf(
                    'Query of type "%s" is not valid',
                    $type
                ));
        }

        if (array_key_exists('boost', $source)) {
            $query->setBoost($source['boost']);
        }

        return $query;
    }

    /**
     * @param array $source
     * @return Template\BoolTemplate
     */
    private static function resolveBoolQuery(array $source) : Template\BoolTemplate
    {
        $template = new Template\BoolTemplate();
        if (array_key_exists('should', $source)) {
            foreach ($source['should'] as $should) {
                $template->addShould(static::resolveQuery($should));
            }
        }
        if (array_key_exists('must', $source)) {
            foreach ($source['must'] as $must) {
                $template->addMust(static::resolveQuery($must));
            }
        }

        return $template;
    }

    /**
     * @param array $source
     * @return Template\DisMaxTemplate
     * @throws InvalidTemplateDefinitionException
     */
    private static function resolveDisMaxQuery(array $source) : Template\DisMaxTemplate
    {
        $template = new Template\DisMaxTemplate();
        if (!array_key_exists('subquery', $source)) {
            throw new InvalidTemplateDefinitionException('DisMaxQuery subquery not defined');
        }

        foreach ($source['subquery'] as $subquery) {
            $template->addSubquery(static::resolveQuery($subquery));
        }

        return $template;
    }

    /**
     * @param array $source
     * @return Template\TermTemplate
     * @throws InvalidTemplateDefinitionException
     */
    private static function resolveTermQuery(array $source) : Template\TermTemplate
    {
        if (!array_key_exists('from', $source)) {
            throw new InvalidTemplateDefinitionException('Term source not defined');
        }
        if (!array_key_exists('map', $source)) {
            throw new InvalidTemplateDefinitionException('Term field not defined');
        }

        $template = new Template\TermTemplate($source['from'], $source['map']);

        return $template;
    }

    /**
     * @param array $source
     * @return Template\TermsTemplate
     * @throws InvalidTemplateDefinitionException
     */
    private static function resolveTermsQuery(array $source) : Template\TermsTemplate
    {
        if (!array_key_exists('from', $source)) {
            throw new InvalidTemplateDefinitionException('Terms source not defined');
        }
        if (!array_key_exists('map', $source)) {
            throw new InvalidTemplateDefinitionException('Terms field not defined');
        }

        $template = new Template\TermsTemplate($source['from'], $source['map']);

        return $template;
    }

    /**
     * @param array $source
     * @return Template\TermCollectionTemplate
     * @throws InvalidTemplateDefinitionException
     */
    private static function resolveTermCollectionQuery(array $source) : Template\TermCollectionTemplate
    {
        if (!array_key_exists('from', $source)) {
            throw new InvalidTemplateDefinitionException('TermCollection source not defined');
        }
        if (!array_key_exists('map', $source)) {
            throw new InvalidTemplateDefinitionException('TermCollection field not defined');
        }
        if (!array_key_exists('distribution', $source)) {
            throw new InvalidTemplateDefinitionException('TermCollection boost distribution not defined');
        }

        $distribution = static::resolveDistribution($source['distribution']);

        $template = new Template\TermCollectionTemplate($source['from'], $source['map'], $distribution);

        return $template;
    }

    /**
     * @param array $source
     * @return Template\SubitemTermTemplate
     * @throws InvalidTemplateDefinitionException
     */
    private static function resolveSubitemTermQuery(array $source) : Template\SubitemTermTemplate
    {
        if (!array_key_exists('from', $source)) {
            throw new InvalidTemplateDefinitionException('SubitemTerm root source not defined');
        }
        if (!array_key_exists('map', $source)) {
            throw new InvalidTemplateDefinitionException('SubitemTerm root field not defined');
        }
        if (!array_key_exists('subitem_from', $source)) {
            throw new InvalidTemplateDefinitionException('SubitemTerm subitem source not defined');
        }
        if (!array_key_exists('subitem_map', $source)) {
            throw new InvalidTemplateDefinitionException('SubitemTerm subitem field not defined');
        }
        if (!array_key_exists('subitem_container_path', $source)) {
            throw new InvalidTemplateDefinitionException('SubitemTerm subitem container path not defined');
        }
        if (!array_key_exists('level_guesser', $source)) {
            throw new InvalidTemplateDefinitionException('SubitemTerm level guesser not defined');
        }
        if (!array_key_exists('distribution', $source)) {
            throw new InvalidTemplateDefinitionException('SubitemTerm boost distribution not defined');
        }

        if (!array_key_exists('root', $source['distribution'])) {
            throw new InvalidTemplateDefinitionException('SubitemDistribution root boost not defined');
        }
        if (!array_key_exists('subitem', $source['distribution'])) {
            throw new InvalidTemplateDefinitionException('SubitemDistribution subitem boost not defined');
        }
    
        $distribution = new Boost\SubitemDistribution(
            $source['distribution']['root'],
            $source['distribution']['subitem'],
            $source['subitem_container_path'],
            new $source['level_guesser']
        );

        if (array_key_exists('additable', $source['distribution'])) {
            $distribution->setAdditable($source['distribution']['additable']);
        }

        return new Template\SubitemTermTemplate(
            $source['from'],
            $source['map'],
            $source['subitem_from'],
            $source['subitem_map'],
            $distribution
        );
    }

    /**
     * @param array $source
     * @return Template\SubitemTermCollectionTemplate
     * @throws InvalidTemplateDefinitionException
     */
    private static function resolveSubitemTermCollectionQuery(array $source) : Template\SubitemTermCollectionTemplate
    {
        if (!array_key_exists('from', $source)) {
            throw new InvalidTemplateDefinitionException('SubitemTermCollection root source not defined');
        }
        if (!array_key_exists('map', $source)) {
            throw new InvalidTemplateDefinitionException('SubitemTermCollection root field not defined');
        }
        if (!array_key_exists('subitem_from', $source)) {
            throw new InvalidTemplateDefinitionException('SubitemTermCollection subitem source not defined');
        }
        if (!array_key_exists('subitem_map', $source)) {
            throw new InvalidTemplateDefinitionException('SubitemTermCollection subitem field not defined');
        }
        if (!array_key_exists('subitem_container_path', $source)) {
            throw new InvalidTemplateDefinitionException('SubitemTermCollection subitem container path not defined');
        }
        if (!array_key_exists('level_guesser', $source)) {
            throw new InvalidTemplateDefinitionException('SubitemTermCollection level guesser not defined');
        }
        if (!array_key_exists('distribution', $source)) {
            throw new InvalidTemplateDefinitionException('SubitemTermCollection boost distribution not defined');
        }

        if (!array_key_exists('root', $source['distribution'])) {
            throw new InvalidTemplateDefinitionException('SubitemDistribution root boost not defined');
        }
        if (!array_key_exists('subitem', $source['distribution'])) {
            throw new InvalidTemplateDefinitionException('SubitemDistribution subitem boost not defined');
        }
    
        $distribution = new Boost\SubitemDistribution(
            $source['distribution']['root'],
            $source['distribution']['subitem'],
            $source['subitem_container_path'],
            new $source['level_guesser']
        );

        if (array_key_exists('additable', $source['distribution'])) {
            $distribution->setAdditable($source['distribution']['additable']);
        }

        return new Template\SubitemTermCollectionTemplate(
            $source['from'],
            $source['map'],
            $source['subitem_from'],
            $source['subitem_map'],
            $distribution
        );
    }

    /**
     * @param array $source
     * @return Template\FunctionScoreTemplate
     * @throws InvalidTemplateDefinitionException
     */
    private static function resolveFunctionScoreQuery(array $source) : Template\FunctionScoreTemplate
    {
        if (!array_key_exists('subquery', $source)) {
            throw new InvalidTemplateDefinitionException('FunctionScore subquery not defined');
        }
        $subquery = static::resolveQuery($source['subquery']);

        if (!array_key_exists('script_score', $source)) {
            throw new InvalidTemplateDefinitionException('FunctionScore script score not defined');
        }

        $scriptScore = static::resolveScriptScore($source['script_score']);
        $template = new Template\FunctionScoreTemplate($subquery, $scriptScore);
        if (array_key_exists('min_score', $source)) {
            $template->setMinimumScore($source['min_score']);
        }
        if (array_key_exists('boost_mode', $source)) {
            $template->setBoostMode($source['boost_mode']);
        }

        return $template;
    }

    /**
     * @param array $source
     * @return Template\ParameterizedQueryCollectionTemplate
     * @throws InvalidTemplateDefinitionException
     */
    private static function resolveParameterizedQueryCollectionQuery(array $source) : Template\ParameterizedQueryCollectionTemplate
    {
        if (!array_key_exists('query', $source)) {
            throw new InvalidTemplateDefinitionException('ParameterizedQueryCollection query not defined');
        }
        if (!array_key_exists('iterator', $source)) {
            throw new InvalidTemplateDefinitionException('ParameterizedQueryCollection iterator not defined');
        }

        return new Template\ParameterizedQueryCollectionTemplate($source['query'], $source['iterator']);
    }

    /**
     * @param array $source
     * @return Boost\ScriptScoreInterface
     * @throws InvalidTemplateDefinitionException
     */
    private static function resolveScriptScore(array $source) : Boost\ScriptScoreInterface
    {
        if (!array_key_exists('type', $source)) {
            throw new InvalidTemplateDefinitionException('Script score type not defined');
        }

        switch ($source['type']) {
            case 'script':
                $score = static::resolveScriptScriptScore($source);
                break;
            default:
                throw new InvalidTemplateDefinitionException(sprintf(
                    'Script score of type "%s" is not valid',
                    $source['type']
                ));
        }

        return $score;
    }

    /**
     * @param array $source
     * @return Boost\ScriptScore\Script
     * @throws InvalidTemplateDefinitionException
     */
    private static function resolveScriptScriptScore(array $source) : Boost\ScriptScore\Script
    {
        if (!array_key_exists('param_provider', $source)) {
            throw new InvalidTemplateDefinitionException('Script script score param provider not defined');
        }
        if (!array_key_exists('script', $source)) {
            throw new InvalidTemplateDefinitionException('Script script score script not defined');
        }

        return new Boost\ScriptScore\Script($source['param_provider'], $source['script']);
    }

    /**
     * @param array $source
     * @return Boost\AbstractDistribution
     * @throws InvalidTemplateDefinitionException
     */
    private static function resolveDistribution(array $source) : Boost\AbstractDistribution
    {
        if (!array_key_exists('type', $source)) {
            throw new InvalidTemplateDefinitionException('Distribution type not defined');
        }

        switch ($source['type']) {
            case 'quadratic':
                $distribution = static::resolveQuadraticDistribution($source);
                break;
            case 'summary':
                $distribution = static::resolveSummaryDistribution($source);
                break;
            case 'constant':
                $distribution = static::resolveConstantDistribution($source);
                break;
            default:
                throw new InvalidTemplateDefinitionException(sprintf(
                    'Distribution of type "%s" is not valid',
                    $source['type']
                ));
        }

        return $distribution;
    }

    /**
     * @param array $source
     * @return Boost\QuadraticDistribution
     * @throws InvalidTemplateDefinitionException
     */
    private static function resolveQuadraticDistribution(array $source) : Boost\QuadraticDistribution
    {
        if (!array_key_exists('from', $source)) {
            throw new InvalidTemplateDefinitionException('QuadraticDistribution x-axis minimum value not defined');
        }
        if (!array_key_exists('to', $source)) {
            throw new InvalidTemplateDefinitionException('QuadraticDistribution x-axis maximum value not defined');
        }

        return new Boost\QuadraticDistribution($source['from'], $source['to']);
    }

    /**
     * @param array $source
     * @return Boost\SummaryDistribution
     */
    private static function resolveSummaryDistribution(array $source)
    {
        $distribution = new Boost\SummaryDistribution();
        if (array_key_exists('boost', $source)) {
            $distribution->setBoost($source['boost']);
        }

        return $distribution;
    }

    /**
     * @param array $source
     * @return Boost\ConstantDistribution
     */
    private static function resolveConstantDistribution(array $source)
    {
        $distribution = new Boost\ConstantDistribution($source['value']);
        if (array_key_exists('boost', $source)) {
            $distribution->setBoost($source['boost']);
        }

        return $distribution;
    }
}
