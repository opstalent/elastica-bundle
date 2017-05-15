<?php

namespace Opstalent\ElasticaBundle\Annotation;

use Doctrine\Common\Annotation\Annotation;

/**
 * @author Patryk Grudniewski <patgrudniewski@gmail.com>
 * @package Opstalent\ElasticaBundle
 *
 * @Annotation
 * @Annotation\Target({"CLASS"})
 */
class Entity
{
    /**
     * @var string
     */
    public $repositoryClass = 'Opstalent\ElasticaBundle\Repository\ElasticsearchRepository';
}
