<?php

namespace Opstalent\ElasticaBundle\Query\Template;

/**
 * @author Patryk Grudniewski <patgrudniewski@gmail.com>
 * @package Opstalent\ElasticaBundle
 */
class DisMaxTemplateResolver extends CompoundTemplateResolver
{
    /**
     * {@inheritdoc}
     */
    protected function getQueryName() : string
    {
        return 'dis_max';
    }

    /**
     * {@inheritdoc}
     */
    protected function getTemplateMapping() : array
    {
        return [
            'subqueries' => '[queries]',
        ];
    }
}
