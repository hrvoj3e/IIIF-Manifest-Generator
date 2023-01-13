<?php

declare(strict_types=1);

/*
 *  This file is part of IIIF Manifest Creator.
 *
 *  IIIF Manifest Creator is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  IIIF Manifest Creator is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with IIIF Manifest Creator.  If not, see <http://www.gnu.org/licenses/>.
 *
 *  @category IIIF\PresentationAPI
 *  @package  Properties
 *  @author   Harry Shyket <harry.shyket@yale.edu>
 *  @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 */

namespace IIIF\PresentationAPI\Properties;

use IIIF\PresentationAPI\Parameters\Identifier;
use IIIF\PresentationAPI\Parameters\Type;
use IIIF\Utils\ArrayCreator;

/**
 * Implementation of thumbnail descriptive property.
 * http://iiif.io/api/presentation/2.1/#thumbnail.
 */
class Thumbnail extends MimeAbstract
{
    private $width;
    private $height;
    private $format;

    public function setFormat(string $format): void
    {
        $this->format = $format;
    }

    public function getFormat()
    {
        return $this->format;
    }

    /**
     * Set the width.
     *
     * @param int $width
     */
    public function setWidth($width): void
    {
        $this->width = $width;
    }

    /**
     * Get the width.
     *
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Set the height.
     *
     * @param int $height
     */
    public function setHeight($height): void
    {
        $this->height = $height;
    }

    /**
     * Get the height.
     *
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    public function toArray()
    {
        $item = parent::toArray();

        ArrayCreator::add($item, Identifier::TYPE, Type::IMAGE);
        ArrayCreator::addIfExists($item, Identifier::HEIGHT, $this->getHeight());
        ArrayCreator::addIfExists($item, Identifier::WIDTH, $this->getWidth());
        ArrayCreator::addIfExists($item, Identifier::FORMAT, $this->getFormat());

        return $item;
    }
}
