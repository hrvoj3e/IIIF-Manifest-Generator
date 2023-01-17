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
 * Implementation of a Range resource.
 * @link https://iiif.io/api/presentation/3.0/#54-range
 */
class Range extends ResourceAbstract
{
    private $onlymemberdata = false;
    private $startCanvas;
    private $contentLayer;

    private $ranges = [];
    private $canvases = [];
    private $members = [];

    public $type = 'sc:Range';

    /**
     * {@inheritDoc}
     *
     * @see \IIIF\PresentationAPI\Resources\ResourceAbstract::setID()
     */
    public function setID($id): void
    {
        Validator::validateURL($id, 'The ID for a Range must be a valid URL');
        parent::setID($id);
    }

    /**
     * Set the startCanvas.
     *
     * @param string
     */
    public function setStartCanvas($startCanvas): void
    {
        $this->startCanvas = $startCanvas;
    }

    /**
     * Get the startCanvas.
     *
     * @return string
     */
    public function getStartCanvas()
    {
        return $this->startCanvas;
    }

    /**
     * Add a range.
     *
     * @param \IIIF\PresentationAPI\Resources\Range $range
     */
    public function addRange(Range $range): void
    {
        array_push($this->ranges, $range);
    }

    /**
     * Get all the ranges.
     *
     * @return array
     */
    public function getRanges()
    {
        return $this->ranges;
    }

    /**
     * Add a canvas.
     *
     * @param \IIIF\PresentationAPI\Resources\Canvas $canvas
     */
    public function addCanvas(Canvas $canvas): void
    {
        array_push($this->canvases, $canvas);
    }

    /**
     * Get all the canvases.
     *
     * @return array
     */
    public function getCanvases()
    {
        return $this->canvases;
    }

    /**
     * Add a range or a canvas. This is used where ordering is important.
     *
     * @param \IIIF\PresentationAPI\Resources\Canvas|\IIIF\PresentationAPI\Resources\Range $member
     */
    public function addMember($member): void
    {
        // Verify that the member being added is either a Range or Canvas type.
        if (!$member instanceof Range && !$member instanceof Canvas) {
            throw new \Exception('A Member of a Range must either be a Range or Canvas');
        } else {
            $member->returnOnlyMemberData();
            array_push($this->members, $member);
        }
    }

    /**
     * Get the members.
     *
     * @return array
     */
    public function getMembers()
    {
        return $this->members;
    }

    /**
     * Set the contentLayer.
     *
     * @param string $contentLayer
     */
    public function setContentLayer($contentLayer): void
    {
        $this->contentLayer = $contentLayer;
    }

    /**
     * Get the contentLayer.
     *
     * @return string
     */
    public function getContentLayer()
    {
        return $this->contentLayer;
    }

    /**
     * Make sure the member is valid.
     *
     * @param \IIIF\PresentationAPI\Resources\Canvas|\IIIF\PresentationAPI\Resources\Range $member
     */
    public function validateMember($member): void
    {
        $methods = [
            'getID',
            'getType',
            'getLabels',
        ];
        Validator::shouldContainItems($member, $methods, 'A member within a Range must contain the ID, Type and Label');
    }

    public function toArray()
    {
        if ($this->getOnlyID()) {
            $id = $this->getID();
            Validator::itemExists($id, 'The id must be present in a Range');
            return $id;
        }

        $array = [];

        if ($this->getOnlyMemberData()) {
            ArrayCreator::addRequired($array, Identifier::ID, $this->getID(), 'The id must be present in the Canvas');
            ArrayCreator::addRequired($array, Identifier::TYPE, $this->getType(), 'The type must be present in the Canvas');
            ArrayCreator::addRequired($array, Identifier::LABEL, $this->label, 'The label must be present in the Range', false);
            ArrayCreator::addIfExists($array, Identifier::CONTENTLAYER, $this->getContentLayer());

            return $array;
        }

        /* Technical Properties **/
        if ($this->isTopLevel()) {
            ArrayCreator::addRequired($array, Identifier::CONTEXT, $this->getContexts(), 'The context must be present in the Range');
        }
        ArrayCreator::addRequired($array, Identifier::ID, $this->getID(), 'The id must be present in the Range');
        ArrayCreator::addRequired($array, Identifier::TYPE, $this->getType(), 'The type must be present in the Range');
        ArrayCreator::addIfExists($array, Identifier::VIEWINGHINT, $this->getViewingHints());
        ArrayCreator::addIfExists($array, Identifier::VIEWINGDIRECTION, $this->getViewingDirection());

        /* Descriptive Properties **/
        ArrayCreator::addRequired($array, Identifier::LABEL, $this->label, 'The label must be present in the Range', false);
        ArrayCreator::addIfExists($array, Identifier::METADATA, $this->getMetadata());

        if (!empty($this->summary)) {
            ArrayCreator::add($array, Identifier::SUMMARY, $this->summary);
        }

        ArrayCreator::addIfExists($array, Identifier::THUMBNAIL, $this->getThumbnails());

        /* Rights and Licensing Properties **/

        if (!empty($this->rights)) {
            ArrayCreator::add($array, Identifier::RIGHTS, $this->rights);
        }

        if (!empty($this->requiredStatement)) {
            ArrayCreator::add($array, Identifier::REQUIRED_STATEMENT, $this->requiredStatement);
        }

        ArrayCreator::addIfExists($array, Identifier::LOGO, $this->getLogos());

        /* Linking Properties **/
        ArrayCreator::addIfExists($array, Identifier::RELATED, $this->getRelated());
        ArrayCreator::addIfExists($array, Identifier::RENDERING, $this->getRendering());
        ArrayCreator::addIfExists($array, Identifier::SERVICE, $this->getServices());
        ArrayCreator::addIfExists($array, Identifier::SEEALSO, $this->getSeeAlso());
        ArrayCreator::addIfExists($array, Identifier::WITHIN, $this->getWithin());
        ArrayCreator::addIfExists($array, Identifier::CONTENTLAYER, $this->getContentLayer());
        ArrayCreator::addIfExists($array, Identifier::STARTCANVAS, $this->getStartCanvas());

        /* Resource Types **/
        ArrayCreator::addIfExists($array, Identifier::CANVASES, $this->getCanvases(), false);
        ArrayCreator::addIfExists($array, Identifier::RANGES, $this->getRanges(), false);
        ArrayCreator::addIfExists($array, Identifier::MEMBERS, $this->getMembers(), false);

        return $array;
    }
}
