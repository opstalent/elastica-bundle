<?php

namespace Opstalent\ElasticaBundle\Query\Template;

use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * @author Patryk Grudniewski <patgrudniewski@gmail.com>
 * @package Opstalent\ElasticaBundle
 */
class TermsTemplateResolver implements TemplateResolverInterface
{
    /**
     * @var \Symfony\Component\PropertyAccess\PropertyAccessor
     */
    protected $propertyAccess;

    public function __construct()
    {
        $this->propertyAccess = PropertyAccess::createPropertyAccessor();
    }

    /**
     * {@inheritdoc}
     */
    public function resolve(AbstractTemplate $template, $data, array $mapping = []) : array
    {
        $field = $template->getField(); // @TODO: mapping as in TermsTemplateResolver
        $source = $this->propertyAccess->getValue($data, $template->getSource());
        $values = $this->extractValues($source);

        return [
            'terms' => [
                $field => $values,
            ],
        ];
    }

    /**
     * @param array|\Traversable $source
     * @return array
     */
    public function extractValues($source) : array
    {
        $propertyAccess = PropertyAccess::createPropertyAccessor();
        $values = [];
        foreach ($source as $item) {
            $values[] = is_object($item) ? $this->propertyAccess->getValue($item, 'id') : $item;
        }

        return $values;
    }
}
