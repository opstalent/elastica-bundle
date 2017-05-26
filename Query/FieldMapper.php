<?php

namespace Opstalent\ElasticaBundle\Query;

/**
 * @author Patryk Grudniewski <patgrudniewski@gmail.com>
 * @package Opstalent\ElasticaBundle
 */
class FieldMapper
{
    /**
     * @param string $field
     * @param array $mapping
     * @return string
     */
    public function map(string $field, array $mapping) : string
    {
        $field = explode('.', $field);
        if (array_key_exists($field[0], $mapping)) {
            $field[0] = $mapping[$field[0]];
        }

        return implode('.', $field);
    }
}
