<?php

declare(strict_types=1);

/*
 * This file is part of IIIF Manifest Creator.
 *
 * IIIF Manifest Creator is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * IIIF Manifest Creator is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with IIIF Manifest Creator.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @category IIIF
 * @package  Utils
 * @author   Harry Shyket <harry.shyket@yale.edu>
 * @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 */

namespace IIIF\Utils;

use Exception;

use function count;
use function is_array;
use function is_object;
use function method_exists;

/**
 * Array creation utilities.
 */
class ArrayCreator
{
     /**
     * Check the array to see if subclasses need to have arrays generated.
     */
    private static function checkToArray(array|bool|float|int|object|string &$value): array|bool|float|int|string
    {
        if (is_array($value)) {
            foreach ($value as &$class) {
                if (is_object($class) && method_exists($class, 'toArray')) {
                    $class = $class->toArray();
                }
            }
        } elseif (is_object($value) && method_exists($value, 'toArray')) {
            $value = $value->toArray();
        }

        return $value;
    }

    /**
     * Add an item to the array.
     */
    public static function add(array &$array, int|string $key, mixed $value, bool $flatten = true): void
    {
        if ($flatten && is_array($value) && count($value) == 1) {
            $value = $value[0];
        }

        $array[$key] = self::checkToArray($value);
    }

    /**
     * The item must exist and be added to the array.
     */
    public static function addRequired(array &$array, int|string $key, mixed $value, string $message, bool $flatten = true): void
    {
        if (empty($value)) {
            throw new Exception($message);
        } else {
            self::add($array, $key, $value, $flatten);
        }
    }

    /**
     * Add the item to the array if it isn't empty.
     */
    public static function addIfExists(array &$array, int|string $key, mixed $value, bool $flatten = true): void
    {
        if (!empty($value)) {
            self::add($array, $key, $value, $flatten);
        }
    }
}
