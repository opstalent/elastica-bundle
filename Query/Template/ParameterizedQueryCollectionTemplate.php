<?php

namespace Opstalent\ElasticaBundle\Query\Template;

/**
 * @author Patryk Grudniewski <patgrudniewski@gmail.com>
 * @package Opstalent\ElasticaBundle
 */
class ParameterizedQueryCollectionTemplate extends AbstractTemplate implements CollectionTemplateInterface
{
    /**
     * @var array
     */
    protected $template;

    /**
     * @var string
     */
    protected $iterator;

    /**
     * @param array $template
     */
    public function __construct(array $template, string $iterator)
    {
        $boost = 1.0;
        if(array_key_exists('boost', $template)) {
            $boost = $template['boost'];
        }

        parent::__construct($boost);

        $this->template = $template;
        $this->iterator = $iterator;
    }

    /**
     * @return array
     */
    public function getTemplate() : array
    {
        return $this->template;
    }

    /**
     * @return string
     */
    public function getIterator() : string
    {
        return $this->iterator;
    }
}
