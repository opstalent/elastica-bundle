<?php

namespace Opstalent\ElasticaBundle\Model;

/**
 * @package AppBundle
 * @author Patryk Grudniewski <patgrudniewski@gmail.com>
 */
interface NestedLevelGuesserInterface
{
    /**
     * @param object $model
     * @return int
     */
    public function getLevel($model) : int;
}
