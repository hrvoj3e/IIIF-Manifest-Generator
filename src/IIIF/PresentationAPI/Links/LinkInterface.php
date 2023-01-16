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

/**
 * Interface for Link properties.
 */
interface LinkInterface
{
    /**
     * Set the id.
     */
    public function setID(string $id): void;

    /**
     * Get the id.
     */
    public function getID(): string;

    /**
     * Set the type.
     */
    public function setType(string $type): void;

    /**
     * Get the type.
     */
    public function getType(): string;

    /**
     * Set the format.
     */
    //public function setFormat(string $format): void;

    /**
     * Get the format.
     */
    //public function getFormat(): string;

    /**
     * Set the profile.
     */
    public function setProfile(string $profile): void;

    /**
     * Get the profile.
     */
    public function getProfile(): string;

    /**
     * Set the profile.
     */
    //public function setLabel(string $label): void;

    /**
     * Get the label.
     */
    //public function getLabel(): string;

    /**
     * Convert objects inside the classes to arrays.
     */
    public function toArray(): array;
}
