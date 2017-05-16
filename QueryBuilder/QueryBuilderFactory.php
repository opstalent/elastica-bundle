<?php

namespace Opstalent\ElasticaBundle\QueryBuilder;

/**
 * @package Opstalent\ElasticaBundle
 * @author Patryk Grudniewski <patgrudniewski@gmail.com>
 */
class QueryBuilderFactory
{
    /**
     * @param string $type
     * @return AbstractQueryBuilder
     * @throws \UnexpectedValueException
     */
    public static function create(string $type) : AbstractQueryBuilder
    {
        switch ($type) {
            case 'bool':
                return new BoolQueryBuilder();
            case 'match':
                return new MatchQueryBuilder();
            case 'wildcard':
                return new WildcardQueryBuilder();
            default:
                throw new \UnexpectedValueException(sprintf('Factory for type "%s" is not defined', $type));
        }
    }
}
