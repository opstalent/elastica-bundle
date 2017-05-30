<?php

namespace Opstalent\ElasticaBundle\Query\Template;

use Opstalent\ElasticaBundle\Query\FieldMapper;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * @author Patryk Grudniewski <patgrudniewski@gmail.com>
 * @package Opstalent\ElasticaBundle
 */
class TermTemplateResolver implements TemplateResolverInterface
{
    /**
     * @var \Symfony\Component\PropertyAccess\PropertyAccessor
     */
    protected $propertyAccess;

    /**
     * @var FieldMapper
     */
    protected $mapper;

    /**
     * @param FieldMapper $mapper
     */
    public function __construct(FieldMapper $mapper)
    {
        $this->propertyAccess = PropertyAccess::createPropertyAccessor();
        $this->mapper = $mapper;
    }

    /**
     * {@inheritdoc}
     */
    public function resolve(AbstractTemplate $template, $data, array $mapping = []) : array
    {
        $field = $this->mapper->map($template->getField(), $mapping);
        $source = $this->propertyAccess->getValue($data, $template->getSource());

        return [
            'term' => [
                $field => [
                    'value' => is_object($source) ? $this->propertyAccess->getValue($source, 'id') : $source,
                    'boost' => $template->getBoost(),
                ]
            ]
        ];
    }
}
