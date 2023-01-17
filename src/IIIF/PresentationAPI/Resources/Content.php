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
 * @package  Resources
 * @author   Harry Shyket <harry.shyket@yale.edu>
 * @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 */

namespace IIIF\PresentationAPI\Resources;

use IIIF\PresentationAPI\Parameters\Identifier;
use IIIF\Utils\ArrayCreator;

/**
 * Implementation of a Content resource.
 * @link https://iiif.io/api/presentation/3.0/#57-content-resources
 */
class Content extends ResourceAbstract
{
    private $format;
    private $width;
    private $height;
    private $chars;

    /**
     * Set the type.
     *
     * @param string $type
     */
    public function setType($type): void
    {
        $this->type = $type;
    }

    /**
     * Set the format.
     *
     * @param string $format
     */
    public function setFormat($format): void
    {
        $this->format = $format;
    }

    /**
     * Get the format.
     *
     * @return string
     */
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

    /**
     * Set the chars.
     *
     * @param string $chars
     */
    public function setChars($chars): void
    {
        $this->chars = $chars;
    }

    /**
     * Get the chars.
     *
     * @return string
     */
    public function getChars()
    {
        return $this->chars;
    }

    /**
     * {@inheritDoc}
     * @see \IIIF\PresentationAPI\Resources\ResourceAbstract::toArray()
     * @return array
     */
    public function toArray()
    {
        $array = [];

        /* Technical Properties **/
        ArrayCreator::addRequired($array, Identifier::ID, $this->getID(), 'The id must be present in a Content resource');
        ArrayCreator::addRequired($array, Identifier::TYPE, $this->getType(), 'The type must be present in a Content resource');
        ArrayCreator::addRequired($array, Identifier::FORMAT, $this->getFormat(), 'The format must be present in a Content resource');
        ArrayCreator::addIfExists($array, Identifier::HEIGHT, $this->getHeight());
        ArrayCreator::addIfExists($array, Identifier::WIDTH, $this->getWidth());
        ArrayCreator::addIfExists($array, Identifier::VIEWINGHINT, $this->getViewingHints());

        /* Descriptive Properties **/

        if (!empty($this->label)) {
            ArrayCreator::add($array, Identifier::LABEL, $this->label, true);
        }

        ArrayCreator::addIfExists($array, Identifier::METADATA, $this->getMetadata());

        if (!empty($this->summary)) {
            ArrayCreator::add($array, Identifier::SUMMARY, $this->summary);
        }

        ArrayCreator::addIfExists($array, Identifier::THUMBNAIL, $this->getThumbnails());
        ArrayCreator::addIfExists($array, Identifier::CHARS, $this->getChars());

        /* Rights and Licensing Properties **/

        if (!empty($this->requiredStatement)) {
            ArrayCreator::add($array, Identifier::REQUIRED_STATEMENT, $this->requiredStatement);
        }

        if (!empty($this->rights)) {
            ArrayCreator::add($array, Identifier::RIGHTS, $this->rights);
        }

        ArrayCreator::addIfExists($array, Identifier::LOGO, $this->getLogos());

        /* Linking Properties **/
        ArrayCreator::addIfExists($array, Identifier::RELATED, $this->getRelated());
        ArrayCreator::addIfExists($array, Identifier::RENDERING, $this->getRendering());
        ArrayCreator::addIfExists($array, Identifier::SERVICE, $this->getServices());
        ArrayCreator::addIfExists($array, Identifier::SEEALSO, $this->getSeeAlso());
        ArrayCreator::addIfExists($array, Identifier::WITHIN, $this->getWithin());

        return $array;
    }
}
