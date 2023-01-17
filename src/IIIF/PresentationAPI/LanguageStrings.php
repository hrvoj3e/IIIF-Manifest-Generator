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
 * @category IIIF\PresentationAPI
 * @package  Metadata
 * @author   Harry Shyket <harry.shyket@yale.edu>
 * @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 */

namespace IIIF\PresentationAPI;

/**
 * Language strings.
 */
class LanguageStrings
{
    protected array $strings = [];

    /**
     * Add a language string.
     *
     * @param string $language
     * @param array  $strings
     */
    public function addString(string $language, array $strings): LanguageStrings
    {
        $this->strings[$language] = $strings;

        return $this;
    }

    /**
     * Returns an array representation of the lange strings object.
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->strings;
    }
}
