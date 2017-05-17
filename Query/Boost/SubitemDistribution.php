<?php

namespace Opstalent\ElasticaBundle\Query\Boost;

use Opstalent\ElasticaBundle\Model\NestedLevelGuesserInterface;

/**
 * @author Patryk Grudniewski <patgrudniewski@gmail.com>
 * @package Opstalent\ElasticaBundle
 */
class SubitemDistribution extends AbstractDistribution
{
    /**
     * @var float
     */
    protected $rootBoost;

    /**
     * @var float
     */
    protected $subitemBoost;

    /**
     * @var bool
     */
    protected $additable;

    /**
     * @var string
     */
    protected $subitemPath;

    /**
     * @var NestedLevelGuesserInterface
     */
    protected $levelGuesser;

    /**
     * @param float $rootBoost
     * @param float $subitemBoost
     * @param string $subitemPath
     * @param NestedLevelGuesserInterface $guesser
     * @param bool $additable
     */
    public function __construct(float $rootBoost, float $subitemBoost, string $subitemPath, NestedLevelGuesserInterface $guesser, $additable = true)
    {
        $this->rootBoost = $rootBoost;
        $this->subitemBoost = $subitemBoost;
        $this->subitemPath = $subitemPath;
        $this->levelGuesser = $guesser;
        $this->additable = $additable;
    }

    /**
     * @param bool $additable
     */
    public function setAdditable(bool $additable)
    {
        $this->additable = $additable;
    }
}
