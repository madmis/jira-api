<?php

namespace madmis\JiraApi\Util;

/**
 * Class Arr
 * @package madmis\JiraApi\Util
 */
class Arr
{
    /**
     * Wrap the values in single quotes
     * @param array $values
     * @return array
     */
    public static function quoteValues(array $values)
    {
        if ($values) {
            return array_map(function ($value) {
                return "'{$value}'";
            }, $values);
        }

        return $values;
    }
}
