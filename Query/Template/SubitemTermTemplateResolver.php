<?php

namespace Opstalent\ElasticaBundle\Query\Template;

use Opstalent\ElasticaBundle\Query\Boost\AbstractDistributionProvider;
use Opstalent\ElasticaBundle\Query\Boost\DistributionProviderFactory;
use Opstalent\ElasticaBundle\Query\FieldMapper;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * @author Patryk Grudniewski <patgrudniewski@gmail.com>
 * @package Opstalent\ElasticaBundle
 */
class SubitemTermTemplateResolver implements TemplateResolverInterface
{
    /**
     * @param DistributionProviderFactory $factory
     * @param FieldMapper $mapper
     */
    public function __construct(DistributionProviderFactory $factory, FieldMapper $mapper)
    {
        $this->propertyAccess = PropertyAccess::createPropertyAccessor();
        $this->distributionFactory = $factory;
        $this->mapper = $mapper;
    }

    /**
     * {@inheritdoc}
     */
    public function resolve(AbstractTemplate $template, $data, array $mapping = []) : array
    {
        $query = [];

        $distribution = $this->distributionFactory->getInstance($template->getDistribution());

        $rootField = $this->mapper->map($template->getField(), $mapping);
        $rootSource = $this->propertyAccess->getValue($data, $template->getSource());

        $subField = $this->mapper->map($template->getSubitemMap(), $mapping);
        $subSource = $this->propertyAccess->getValue($data, $template->getSubitemFrom());

        if (null === $rootSource) {
            return $query;
        }
        $query[] = [
            'term' => [$rootField => $this->resolveItem($rootSource, $distribution)],
        ];

        if (null !== $subSource) {
            $query[] = [
                'term' => [$subField => $this->resolveItem($subSource, $distribution)],
            ];
        }

        return $query;
    }

    /**
     * @param object|scalar $item
     * @param AbstractDistributionProvider $provider
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
}
