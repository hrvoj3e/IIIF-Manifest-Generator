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
use IIIF\Utils\Validator;

/**
 * Implementation of a Canvas resource.
 * @link https://iiif.io/api/presentation/3.0/#53-canvas
 */
class Canvas extends ResourceAbstract
{
    private $onlymemberdata = false;
    private $width;
    private $height;

    private $images = [];
    private $otherContents = [];

    public $type = 'sc:Canvas';

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
     * Add an image.
     *
     * @param \IIIF\PresentationAPI\Resources\Annotation $annotation
     */
    public function addImage(Annotation $annotation): void
    {
        array_push($this->images, $annotation);
    }

    /**
     * Get all images.
     *
     * @return array
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Add an annotation list.
     *
     * @param \IIIF\PresentationAPI\Resources\AnnotationList $otherContent
     */
    public function addOtherContent(AnnotationList $otherContent): void
    {
        array_push($this->otherContents, $otherContent);
    }

    /**
     * Get all annotation lists.
     *
     * @return array
     */
    public function getOtherContents()
    {
        return $this->otherContents;
    }

    /**
     * Configure the proper dimensions when the width and height are not set.
     */
    public function configureDimensions(): void
    {
        // If the canvas width is not set, then look for the largest width within the contained images
        if (empty($this->getWidth())) {
            $largestWidth = null;
            foreach ($this->getImages() as $image) {
                $newWidth = $image->getContent()->getWidth();
                if (empty($largestWidth) || $newWidth > $largestWidth) {
                    $largestWidth = $newWidth;
                }
            }
        }

        // If the canvas height is not set, then look for the largest width within the contained images
        if (empty($this->getHeight())) {
            $largestHeight = null;
            foreach ($this->getImages() as $image) {
                $newHeight = $image->getContent()->getHeight();
                if (empty($largestHeight) || $newHeight > $largestHeight) {
                    $largestHeight = $newHeight;
                }
            }
        }

        // If there are no width and height found in the images, do the default functionality
         //
        if (!empty($largestWidth) && !empty($largestHeight)) {
            if ($largestWidth < 1200 || $largestHeight < 1200) {
                $this->setWidth($largestWidth * 2);
                $this->setHeight($largestHeight * 2);
            }
        }
    }

    public function toArray()
    {
        if ($this->getOnlyID()) {
            $id = $this->getID();
            Validator::itemExists($id, 'The id must be present in the Canvas');
            return $id;
        }

        $array = [];

        if ($this->getOnlyMemberData()) {
            ArrayCreator::addRequired($array, Identifier::ID, $this->getID(), 'The id must be present in the Canvas');
            ArrayCreator::addRequired($array, Identifier::TYPE, $this->getType(), 'The type must be present in the Canvas');
            ArrayCreator::addRequired($array, Identifier::LABEL, $this->getLabels(), 'The label must be present in the Canvas');

            return $array;
        }

        /* Technical Properties **/
        if ($this->isTopLevel()) {
            ArrayCreator::addRequired($array, Identifier::CONTEXT, $this->getContexts(), 'The context must be present in the Canvas');
        }
        ArrayCreator::addRequired($array, Identifier::ID, $this->getID(), 'The id must be present in the Canvas');
        ArrayCreator::addRequired($array, Identifier::TYPE, $this->getType(), 'The type must be present in the Canvas');
        ArrayCreator::addIfExists($array, Identifier::VIEWINGHINT, $this->getViewingHints());
        $this->configureDimensions();
        ArrayCreator::addRequired($array, Identifier::HEIGHT, $this->getHeight(), 'The height must be present in the Canvas');
        ArrayCreator::addRequired($array, Identifier::WIDTH, $this->getWidth(), 'The width must be present in the Canvas');

        /* Descriptive Properties **/
        ArrayCreator::addRequired($array, Identifier::LABEL, $this->label, 'The label must be present in the Canvas', false);
        ArrayCreator::addIfExists($array, Identifier::METADATA, $this->getMetadata());

        if (!empty($this->summary)) {
            ArrayCreator::add($array, Identifier::SUMMARY, $this->summary);
        }

        ArrayCreator::addIfExists($array, Identifier::THUMBNAIL, $this->getThumbnails());

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

        /* Resource Types **/
        ArrayCreator::addIfExists($array, Identifier::IMAGES, $this->getImages(), false);
        ArrayCreator::addIfExists($array, Identifier::OTHERCONTENT, $this->getOtherContents(), false);

        return $array;
    }
}
