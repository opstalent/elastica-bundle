<?php

namespace Opstalent\ElasticaBundle\Query\Template;

use Opstalent\ElasticaBundle\Query\Query;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * @author Patryk Grudniewski <patgrudniewski@gmail.com>
 * @package Opstalent\ElasticaBundle
 */
abstract class CompoundTemplateResolver implements TemplateResolverInterface
{
    /**
     * @var TemplateResolverFactory
     */
    protected $resolverFactory;

    /**
     * @param TemplateResolverFactory $factory
     */
    public function __construct(TemplateResolverFactory $factory)
    {
        $this->resolverFactory = $factory;
    }

    /**
     * {@inheritdoc}
     */
    public function resolve(AbstractTemplate $template, $data, array $mapping = []) : array
    {
        $query = [
            $this->getQueryName() => [
                'boost' => $template->getBoost(),
            ],
        ];

        $propertyAccess = PropertyAccess::createPropertyAccessor();

        foreach ($this->getTemplateMapping() as $source => $dest) {
            $part = $propertyAccess->getValue($template, $source);
            $partQuery = $this->resolvePart($part, $data, $mapping);

            $dest = sprintf('[%s]%s', $this->getQueryName(), $dest);
            $propertyAccess->setValue($query, $dest, $partQuery);
        }

        return $query;
    }

    /**
     * @return array
     */
    abstract protected function getTemplateMapping() : array;

    /**
     * @return string
     */
    abstract protected function getQueryName() : string;

    /**
     * @param array $querries
     * @param object $data
     * @param array $mapping
     * @return array
     */
    protected function resolvePart(array $querries, $data, array $mapping = []) : array
    {
        $part = [];
        foreach ($querries as $template) {
            if ($template instanceof Query) {
                $query = $template->getQuery();
            } else {
                $resolver = $this->resolverFactory->getInstance($template);
                $query = $resolver->resolve($template, $data, $mapping);
            }

            if ($template instanceof CollectionTemplateInterface) {
                $part = array_merge($part, $query);
            } else {
                $part[] = $query;
            }
        }

        return $part;
    }
}
