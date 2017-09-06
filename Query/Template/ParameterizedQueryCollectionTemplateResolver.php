<?php

namespace Opstalent\ElasticaBundle\Query\Template;

use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * @author Patryk Grudniewski <patgrudniewski@gmail.com>
 * @package Opstalent\ElasticaBundle
 */
class ParameterizedQueryCollectionTemplateResolver implements TemplateResolverInterface
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
     * @throws \UnexpectedValueException
     */
    public function resolve(AbstractTemplate $template, $data, array $mapping = []) : array
    {
        $iterator = $this->propertyAccess->getValue($data, $template->getIterator());
        if (!(is_array($iterator) || $iterator instanceof \Traversable)) {
            $queries[] = $this->resolveTemplate($template->getTemplate(), $iterator); //@TODO: use mapping
            return $queries;
        }

        $queries = [];
        foreach ($iterator as $item) {
            $queries[] = $this->resolveTemplate($template->getTemplate(), $item); //@TODO: use mapping
        }

        return $queries;
    }

    /**
     * @param array $template
     * @param object $data
     * @return array
     */
    private function resolveTemplate(array $template, $data) : array
    {
        $query = [];
        foreach ($template as $key => $value) {
            if (is_array($value)) {
                $value = $this->resolveTemplate($value, $data);
            } elseif ('$' == $value[0]) {
                $value = $this->propertyAccess->getValue($data, substr($value, 1));
            }

            $query[$key] = $value;
        }

        return $query;
    }
}
