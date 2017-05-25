<?php

namespace Opstalent\ElasticaBundle\Exception;

use Elastica\Query;

/**
 * @author Patryk Grudniewski <patgrudniewski@gmail.com>
 * @package Opstalent\ElasticaBundle
 */
class DocumentNotFoundException extends \Exception implements Exception
{
    /**
     * @var Query
     */
    protected $query;

    /**
     * @param string $document
     * @param int $id
     */
    public function __construct(string $document, Query $query)
    {
        $this->query = $query;

        parent::__construct(sprintf(
            'Document of type "%s" and identifier "%s" not found',
            $document,
            $id
        ));
    }

    /**
     * @return Query
     */
    public function getQuery() : Query
    {
        return $this->query;
    }
}
