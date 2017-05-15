<?php

namespace Opstalent\ElasticaBundle\Repository;

use Opstalent\ApiBundle\Repository\SearchableRepositoryInterface;

/**
 * @author Patryk Grudniewski <patgrudniewski@gmail.com>
 * @package Opstalent\ElasticaBundle
 */
interface ElasticsearchRepositoryInterface extends SearchableRepositoryInterface
{
    /**
     * @return array
     */
    public function getFieldsMapping() : array;
}
