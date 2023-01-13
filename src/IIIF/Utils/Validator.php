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
use ReflectionClass;

use function filter_var;
use function in_array;
use function is_int;
use function substr;

/**
 * Validation utilities.
 */
class Validator
{
    /**
     * Checks that an item is non-empty.
     */
    public static function itemExists(mixed $item, string $message): bool
    {
        if (empty($item)) {
            throw new Exception($message);
        }

        return true;
    }

    /**
     * Checks that an item exists within an array.
     */
    public static function inArray(mixed $item, array $array, string $message): bool
    {
        if (!in_array($item, $array)) {
            throw new Exception($message);
        }

        return true;
    }

    /**
     * Checks that the provided item is a valid URL.
     */
    public static function validateURL(mixed $url, string $message): bool
    {
        if (!filter_var($url, FILTER_VALIDATE_URL) !== false) {
            throw new Exception($message);
        }

        return true;
    }

    /**
     * Checks that the provided item is an integer greater than zero.
     */
    public static function greaterThanZero(mixed $num, string $message): bool
    {
        if (!is_int($num) || !($num > 0)) {
            throw new Exception($message);
        }

        return true;
    }

    /**
     * Checks that the provided item is an integer greater than or equal to zero.
     */
    public static function greaterThanEqualZero(mixed $num, string $message): bool
    {
        if (!is_int($num) || !($num >= 0)) {
            throw new Exception($message);
        }

        return true;
    }

    /**
     * Test to make sure the methods of a class are not empty.
     */
    public static function shouldContainItems(object $item, array $methods, string $message): void
    {
        foreach ($methods as $method) {
            if (empty($item->$method())) {
                throw new Exception($message);
            }
        }
    }

    /**
     * Make sure the embedded object does not contain extra items.
     */
    public static function shouldNotContainItems(object $item, string $classname, array $exclusions, string $message): void
    {
        $class = new ReflectionClass($classname);

        foreach ($class->getMethods() as $method) {
            $name = $method->name;

            if (substr($name, 0, 3) == 'get' && !in_array($name, $exclusions)) {
                if (!empty($item->$name())) {
                    throw new Exception($message);
                }
            }
        }
    }
}
