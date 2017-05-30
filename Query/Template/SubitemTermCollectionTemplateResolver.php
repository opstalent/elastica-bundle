<?php

namespace Opstalent\ElasticaBundle\Query\Template;

use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * @author Patryk Grudniewski <patgrudniewski@gmail.com>
 * @package Opstalent\ElasticaBundle
 */
class SubitemTermCollectionTemplateResolver extends TermCollectionTemplateResolver
{
    /**
     * {@inheritdoc}
     */
    public function resolve(AbstractTemplate $template, $data, array $mapping = []) : array
    {
        $query = array_merge(
            parent::resolve($template, $data, $mapping),
            parent::resolve(
                new TermCollectionTemplate(
                    $template->getSubitemFrom(),
                    $template->getSubitemMap(),
                    $template->getDistribution()
                ),
                $data,
                $mapping
            )
        );

        return $query;
    }
}
