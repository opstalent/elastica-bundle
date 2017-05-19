<?php

namespace Opstalent\ElasticaBundle\Query\Template;

use Opstalent\ElasticaBundle\Query\Boost\ScriptScoreInterface;
use Opstalent\ElasticaBundle\Query\QueryInterface;

/**
 * @author Patryk Grudniewski <patgrudniewski@gmail.com>
 * @package Opstalent\ElasticaBundle
 */
class FunctionScoreTemplate extends AbstractTemplate
{
    /**
     * @var QueryInterface
     */
    protected $query;

    /**
     * @var ScriptScoreInterface
     */
    protected $scriptScore;

    /**
     * @param QueryInterface $query
     * @param ScriptScoreInterface $scriptScore
     * {@inheritdoc}
     */
    public function __construct(QueryInterface $query, ScriptScoreInterface $scriptScore, float $boost = 1.0)
    {
        parent::__construct($boost);
        $this->query = $query;
        $this->scriptScore = $scriptScore;
    }

    /**
     * @return QueryInterface
     */
    public function getQuery() : QueryInterface
    {
        return $this->query;
    }

    /**
     * @return ScriptScoreInterface
     */
    public function getScriptScore() : ScriptScoreInterface
    {
        return $this->scriptScore;
    }
}
