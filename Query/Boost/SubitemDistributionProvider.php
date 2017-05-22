<?php

namespace Opstalent\ElasticaBundle\Query\Boost;

use Symfony\Component\PropertyAccess\Exception\AccessException;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * @author Patryk Grudniewski <patgrudniewski@gmail.com>
 * @package Opstalent\ElasticaBundle
 */
class SubitemDistributionProvider extends AbstractDistributionProvider
{
    /**
     * @var array
     */
    protected $boostTable;

    /**
     * {@inheritdoc}
     */
    public function setDistribution(DistributionInterface $distribution)
    {
        parent::setDistribution($distribution);

        $this->boostTable = $distribution->getBoostArray();

        $boost = array_sum($this->boostTable);
        if ($boost != 1) {
            foreach ($this->boostTable as &$item) {
                $item /= $boost;
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getValue($data) : float
    {
        $level = $this->distribution->getLevelGuesser()->getLevel($data);

        if (!$this->hasItemChildren($data) && $this->distribution->isAdditable()) {
            return array_sum(array_slice($this->boostTable, $level));
        } else {
            return $this->boostTable[$level];
        }
    }

    /**
     * @param object $item
     * @return bool
     */
    public function hasItemChildren($data)
    {
        $propertyAccessor = PropertyAccess::createPropertyAccessor();
        try {
            $subitems = $propertyAccessor->getValue($data, $this->distribution->getSubitemPath());
        } catch (AccessException $e) {
            return false;
        }

        return (bool) count($subitems);
    }
}
