<?php

namespace Opstalent\ElasticaBundle\Transformer;

use FOS\ElasticaBundle\Doctrine\ORM\ElasticaToModelTransformer as BaseTransformer;
use FOS\ElasticaBundle\Transformer\HighlightableModelInterface;
use Opstalent\ElasticaBundle\Model\ScorableInterface;

/**
 * @author Patryk Grudniewski <patgrudniewski@gmail.com>
 * @package Opstalent\ElasticaBundle
 */
class ElasticaToModelTransformer extends BaseTransformer
{
    /**
     * {@inheritdoc}
     */
    public function transform(array $elasticaObjects)
    {
        $objects = parent::transform($elasticaObjects);

        $scores = [];
        foreach ($elasticaObjects as $elasticaObject) {
            $scores[$elasticaObject->getId()] = $elasticaObject->getScore();
        }
        $propertyAccessor = $this->propertyAccessor;
        $identifier = $this->options['identifier'];
        foreach ($objects as $object) {
            if ($object instanceof ScorableInterface) {
                $id = (string) $propertyAccessor->getValue($object, $identifier);
                $object->setScore($scores[$id]);
            }
        }

        return $objects;
    }
}
