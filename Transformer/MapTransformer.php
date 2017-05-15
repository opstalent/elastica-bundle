<?php

namespace Opstalent\ElasticaBundle\Transformer;

/**
 * @author Patryk Grudniewski <patgrudniewski@gmail.com>
 * @package Opstalent\ElasticaBundle
 */
class MapTransformer
{
    /**
     * @var array
     */
    protected $map;

    /**
     * @param array $map
     */
    public function __construct(array $map)
    {
        $this->map = $map;
    }

    /**
     * @param array $data
     * @return array
     */
    public function transform(array $data) : array
    {
        return $this->map($data, $this->map);
    }

    /**
     * @param array $data
     * @return array
     */
    public function reverseTransform(array $data) : array
    {
        return $this->map($data, array_flip($this->map));

    }

    /**
     * @param array $data
     * @param array $map
     * @return array
     */
    private function map(array $data, array $map) : array
    {
        $mapped = [];
        foreach ($data as $key => $item) {
            $mapped[$key] = array_key_exists($item, $this->map) ? $this->map[$item] : $item;
        }

        return $mapped;
    }
}
