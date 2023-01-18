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
 * @package  Properties
 * @author   Harry Shyket <harry.shyket@yale.edu>
 * @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 */

namespace IIIF\PresentationAPI\Properties;

use IIIF\PresentationAPI\ArrayableInterface;
use IIIF\PresentationAPI\Links\Service;
use IIIF\PresentationAPI\Parameters\Identifier;
use IIIF\PresentationAPI\Parameters\Type;
use IIIF\Utils\ArrayCreator;

/**
 * Implementation for image resources.
 */
abstract class ImageAbstract implements ArrayableInterface
{
    protected string|null $id = null;

    protected Service|null $service = null;

    private int|null $width = null;

    private int|null $height = null;

    private string|null $format = null;

    /**
     * Set the id.
     */
    public function setID(string $id): void
    {
        $this->id = $id;
    }

    /**
     * Get the id.
     */
    public function getID(): ?string
    {
        return $this->id;
    }

    /**
     * Set the service.
     */
    public function setService(Service $service): void
    {
        $this->service = $service;
    }

    /**
     * Get the service.
     */
    public function getService(): ?Service
    {
        return $this->service;
    }

    /**
     * Set the format.
     */
    public function setFormat(string $format): void
    {
        $this->format = $format;
    }

    /**
     * Get the format.
     */
    public function getFormat(): ?string
    {
        return $this->format;
    }

    /**
     * Set the width.
     */
    public function setWidth(int $width): void
    {
        $this->width = $width;
    }

    /**
     * Get the width.
     */
    public function getWidth(): ?int
    {
        return $this->width;
    }

    /**
     * Set the height.
     */
    public function setHeight(int $height): void
    {
        $this->height = $height;
    }

    /**
     * Get the height.
     */
    public function getHeight(): ?int
    {
        return $this->height;
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        $array = [];

        ArrayCreator::addRequired($array, Identifier::ID, $this->id, 'The id must be present in the image.');

        ArrayCreator::add($array, Identifier::TYPE, Type::IMAGE);

        if (!empty($this->format)) {
            ArrayCreator::add($array, Identifier::FORMAT, $this->format);
        }

        if (!empty($this->height)) {
            ArrayCreator::add($array, Identifier::HEIGHT, $this->height);
        }

        if (!empty($this->width)) {
            ArrayCreator::add($array, Identifier::WIDTH, $this->width);
        }

        if (!empty($this->service)) {
            ArrayCreator::add($array, Identifier::SERVICE, $this->service);
        }

        return $array;
    }
}
