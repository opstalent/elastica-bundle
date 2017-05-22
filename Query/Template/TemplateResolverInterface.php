<?php

namespace Opstalent\ElasticaBundle\Query\Template;

/**
 * @author Patryk Grudniewski <patgrudniewski@gmail.com>
 * @package Opstalent\ElasticaBundle
 */
interface TemplateResolverInterface
{
    /**
     * @param AbstractTemplate $template
     * @param object $data
     * @param array $mapping
     * @return array
     */
    public function resolve(AbstractTemplate $template, $data, array $mapping = []) : array;
}
