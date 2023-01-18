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
 * @package  Links
 * @author   Harry Shyket <harry.shyket@yale.edu>
 * @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 */

namespace IIIF\PresentationAPI\Links;

use IIIF\PresentationAPI\Parameters\Identifier;
use IIIF\Utils\ArrayCreator;

/**
 * Implemenation for homepage linking property.
 * @link https://iiif.io/api/presentation/3.0/#homepage
 */
class Homepage extends LinkAbstract
{
    /**
     * Does not implement setProfile.
     *
     * @throws Exception
     */
    public function setProfile($service): void
    {
        throw new \Exception('Homepage does not have a profile');
    }

    /**
     * Does not implement getProfile.
     *
     * @throws Exception
     */
    public function getProfile(): string
    {
        throw new \Exception('Homepage does not have a profile');
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        $array = [];

        ArrayCreator::addRequired($array, Identifier::ID, $this->id, 'The id must be present in a homepage item');
        ArrayCreator::addRequired($array, Identifier::LABEL, $this->label, 'The label must be present in a homepage item');
        ArrayCreator::addRequired($array, Identifier::FORMAT, $this->format, 'The format must be present in a homepage item');

        if (!empty($this->format)) {
            ArrayCreator::add($array, Identifier::FORMAT, $this->format);
        }

        if (!empty($this->language)) {
            ArrayCreator::add($array, Identifier::LANGUAGE, $this->language);
        }

        return $array;
    }
}
