<?php

namespace Opstalent\ElasticaBundle\Query\Template;

use Opstalent\ElasticaBundle\Query\Boost\SubitemDistribution;

/**
 * @author Patryk Grudniewski <patgrudniewski@gmail.com>
 * @package Opstalent\ElasticaBundle
 */
class SubitemTermCollectionTemplate extends TermCollectionTemplate
{
    /**
     * @var string
     */
    protected $subitemFrom;

    /**
     * @var string
     */
    protected $subitemMap;

    /**
     * @param string $from
     * @param string $map
     * @param string $subitemFrom
     * @param string $subitemMap
     * @param SubitemDistribution $dist
     */
    public function __construct(string $from, string $map, string $subitemFrom, string $subitemMap, SubitemDistribution $dist)
    {
        parent::__construct($from, $map, $dist);
        $this->subitemFrom = $subitemFrom;
        $this->subitemMap = $subitemMap;
    }
}
