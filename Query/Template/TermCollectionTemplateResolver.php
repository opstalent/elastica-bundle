<?php

namespace Opstalent\ElasticaBundle\Query\Template;

use Opstalent\ElasticaBundle\Query\Boost\AbstractDistributionProvider;
use Opstalent\ElasticaBundle\Query\Boost\CompoundDistributionProvider;
use Opstalent\ElasticaBundle\Query\Boost\DistributionProviderFactory;
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

    /**
     * @var DistributionProviderFactory
     */
    protected $distributionFactory;

    /**
     * @param DistributionProviderFactory $factory
     */
    public function __construct(DistributionProviderFactory $factory)
    {
        $this->propertyAccess = PropertyAccess::createPropertyAccessor();
        $this->distributionFactory = $factory;
    }

    /**
     * {@inheritdoc}
     */
    public function resolve(AbstractTemplate $template, $data, array $mapping = []) : array
    {
        $query = [];

        $field = $this->map($template->getField(), $mapping);
        $source = $this->propertyAccess->getValue($data, $template->getSource());

        $distribution = $this->distributionFactory->getInstance($template->getDistribution());
        if ($distribution instanceof CompoundDistributionProvider) {
            $distribution->setCount(count($source));
        }

        foreach ($source as $item) {
            $query[] = [
                'term' => [$field => $this->resolveItem($item, $distribution)],
            ];
        }

        return $query;
    }

    /**
     * @param object|scalar $item
     * @param AbstractDistributionProvider
     * @return array
     */
    protected function resolveItem($item, AbstractDistributionProvider $provider) : array
    {
        $value = is_object($item) ? $this->propertyAccess->getValue($item, 'id') : $item;

        return [
            'value' => $value,
            'boost' => $provider->getValue($item),
        ];
    }

    /**
     * @param string $field
     * @param array $mapping
     * @return string
     *
     * @TODO: move to service
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
