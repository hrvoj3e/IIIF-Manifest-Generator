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
 * Implementation of a Sequence resource.
 * http://iiif.io/api/presentation/2.1/#sequence.
 */
class Sequence extends ResourceAbstract
{
    private $startCanvas;

    private $canvases = [];

    public $type = 'sc:Sequence';

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
     * Add a Canvas.
     *
     * @param \IIIF\PresentationAPI\Resources\Canvas $canvas
     */
    public function addCanvas($canvas): void
    {
        array_push($this->canvases, $canvas);
    }

    public function getCanvases()
    {
        return $this->canvases;
    }

    public function toArray()
    {
        $array = [];

        /* Technical Properties **/

        if ($this->getOnlyMemberData()) {
            ArrayCreator::addRequired($array, Identifier::ID, $this->getID(), 'The id must be present in a Manifest');
            ArrayCreator::addRequired($array, Identifier::TYPE, $this->getType(), 'The type must be present in a Manifest');
            ArrayCreator::addRequired($array, Identifier::LABEL, $this->label, 'The label must be present in the Sequence', false);

            return $array;
        }

        if ($this->isTopLevel()) {
            ArrayCreator::addRequired($array, Identifier::CONTEXT, $this->getContexts(), 'The context must be present in the Manifest');
        }

        ArrayCreator::addRequired($array, Identifier::ID, $this->getID(), 'The id must be present in the Manifest');
        ArrayCreator::addRequired($array, Identifier::TYPE, $this->getType(), 'The type must be present in the Manifest');
        ArrayCreator::addIfExists($array, Identifier::VIEWINGHINT, $this->getViewingHints());
        ArrayCreator::addIfExists($array, Identifier::VIEWINGDIRECTION, $this->getViewingDirection());

        /* Descriptive Properties **/

        if (!empty($this->label)) {
            ArrayCreator::add($array, Identifier::LABEL, $this->label, true);
        }

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
        ArrayCreator::addIfExists($array, Identifier::STARTCANVAS, $this->getStartCanvas());

        /* Resource Types **/
        ArrayCreator::addRequired($array, Identifier::CANVASES, $this->getCanvases(), 'Canvases must be present in a Sequence', false);

        return $array;
    }
}
