<?php

namespace Opstalent\ElasticaBundle\Query\Template;

/**
 * @author Patryk Grudniewski <patgrudniewski@gmail.com>
 * @package Opstalent\ElasticaBundle
 */
class TermsTemplate extends AbstractTemplate
{
    /**
     * @var string
     */
    protected $source;

    /**
     * @var string
     */
    protected $field;

    /**
     * @param string $source
     * @param string $field
     * {@inheritdoc}
     */
    public function __construct(string $source, string $field, float $boost = 1.0)
    {
        parent::__construct($boost);

        $this->source = $source;
        $this->field = $field;
    }

    /**
     * @return string
     */
    public function getSource() : string
    {
        return $this->source;
    }

    /**
     * @return string
     */
    public function getField() : string
    {
        return $this->field;
    }
}
