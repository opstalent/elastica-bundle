<?php

namespace Opstalent\ElasticaBundle\QueryBuilder;

/**
 * @package Opstalent\ElasticaBundle
 * @author Patryk Grudniewski <patgrudniewski@gmail.com>
 */
class QueryBuilderFactory
{
    const BOOL = 'bool';
    const MATCH = 'match';
    const RANGE = 'range';
    const WILDCARD = 'wildcard';
    const TERMS = 'terms';
    /**
     * @param string $type
     * @return AbstractQueryBuilder
     * @throws \UnexpectedValueException
     */
    public static function create(string $type) : AbstractQueryBuilder
    {
        switch ($type) {
            case self::BOOL:
                return new BoolQueryBuilder();
            case self::MATCH:
                return new MatchQueryBuilder();
            case self::RANGE:
                return new RangeQueryBuilder();
            case self::WILDCARD:
                return new WildcardQueryBuilder();
            case self::TERMS:
                return new TermsQueryBuilder();
            default:
                throw new \UnexpectedValueException(sprintf('Factory for type "%s" is not defined', $type));
        }
    }
}
