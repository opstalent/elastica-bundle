<?php

namespace Opstalent\ElasticaBundle\Query\Template;

use Opstalent\ElasticaBundle\Query\Boost\AbstractDistributionProvider;
use Opstalent\ElasticaBundle\Query\Boost\CompoundDistributionProvider;
use Opstalent\ElasticaBundle\Query\Boost\DistributionProviderFactory;
use Opstalent\ElasticaBundle\Query\Boost\SummaryDistributionProvider;
use Opstalent\ElasticaBundle\Query\FieldMapper;
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
     * @var FieldMapper
     */
    protected $mapper;

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

        $field = $this->mapper->map($template->getField(), $mapping);
        $source = $this->propertyAccess->getValue($data, $template->getSource());

        $distribution = $this->distributionFactory->getInstance($template->getDistribution());
        if ($distribution instanceof CompoundDistributionProvider) {
            $distribution->setCount(count($source));
        }

        if ($distribution instanceof SummaryDistributionProvider) {
            $distribution->setBoostPool($template->getBoost());
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
}
