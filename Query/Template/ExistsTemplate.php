<?php

namespace Opstalent\ElasticaBundle\Query\Template;

/**
 * @author Tomasz Piasecki <patgrudniewski@gmail.com>
 * @package Opstalent\ElasticaBundle
 */
class ExistsTemplate extends AbstractTemplate
{

    /**
     * @var string
     */
    protected $field;

    public function __construct(string $field, float $boost = 1.0)
    {
        parent::__construct($boost);

        $this->field = $field;
    }

    /**
     * @return string
     */
    public function getField(): string
    {
        return $this->field;
    }
}
