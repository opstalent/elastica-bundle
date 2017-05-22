<?php

namespace Opstalent\ElasticaBundle\Query\Template;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @author Patryk Grudniewski <patgrudniewski@gmail.com>
 * @package Opstalent\ElasticaBundle
 */
class TemplateResolverFactory extends ArrayCollection
{
    /**
     * @param array
     */
    private $instances = [];

    /**
     * @param AbstractTemplate $template
     * @return TemplateResolverInterface
     */
    public function getInstance(AbstractTemplate $template) : TemplateResolverInterface
    {
        $resolverClass = $template->getResolverClass();
        if (!array_key_exists($resolverClass, $this->instances)) {
            $this->createInstance($resolverClass);
        }

        return $this->instances[$resolverClass];
    }

    /**
     * @param TemplateResolverInterface $resolver
     */
    public function addTemplateResolver(TemplateResolverInterface $resolver)
    {
        $this->instances[get_class($resolver)] = $resolver;
    }

    /**
     * @param string $resolverClass
     */
    private function createInstance(string $resolverClass)
    {
        $this->addTemplateResolver(new $resolverClass);
    }
}
