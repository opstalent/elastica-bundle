<?php

namespace Opstalent\ElasticaBundle\Exception;

/**
 * @author Patryk Grudniewski <patgrudniewski@gmail.com>
 * @package Opstalent\ElasticaBundle
 */
class UnsupportedQueryTypeException extends \Exception implements Exception
{
    /**
     * @param string $type
     */
    public function __construct(string $type)
    {
        parent::__construct(sprintf('Query of type "%s" is not supported', $type));
    }
}
