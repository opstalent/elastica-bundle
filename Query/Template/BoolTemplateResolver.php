<?php

namespace Opstalent\ElasticaBundle\Query\Template;

/**
 * @author Patryk Grudniewski <patgrudniewski@gmail.com>
 * @package Opstalent\ElasticaBundle
 */
class BoolTemplateResolver extends CompoundTemplateResolver
{
    /**
     * {@inheritdoc}
     */
    protected function getQueryName() : string
    {
        return 'bool';
    }

    /**
     * {@inheritdoc}
     */
    protected function getTemplateMapping() : array
    {
        return [
            'should' => '[should]',
            'must' => '[must]',
            'must_not' => '[must_not]',
        ];
    }
}
