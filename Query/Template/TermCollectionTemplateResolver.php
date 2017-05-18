<?php

namespace Opstalent\ElasticaBundle\Query\Template;

use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * @author Patryk Grudniewski <patgrudniewski@gmail.com>
 * @package Opstalent\ElasticaBundle
 */
class TermCollectionTemplateResolver implements TemplateResolverInterface
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
        $query = [];

        $field = $this->map($template->getField(), $mapping);

        $source = $this->propertyAccess->getValue($data, $template->getSource());
        foreach ($source as $item) {
            $query[] = [
                'term' => [$field => $this->resolveItem($item)],
            ];
        }

        return $query;
    }

    /**
     * @param object|scalar $item
     * @return array
     */
    protected function resolveItem($item) : array
    {
        $value = is_object($item) ? $this->propertyAccess->getValue($item, 'id') : $item;

        return [
            'value' => $value,
        ];
    }

    /**
     * @param string $field
     * @param array $mapping
     * @return string
     */
    protected function map(string $field, array $mapping) : string
    {
        $field = explode('.', $field);
        if (array_key_exists($field[0], $mapping)) {
            $field[0] = $mapping[$field[0]];
        }

        return implode('.', $field);
    }
}
