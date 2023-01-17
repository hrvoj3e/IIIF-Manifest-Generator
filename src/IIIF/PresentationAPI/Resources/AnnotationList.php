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
use IIIF\PresentationAPI\Parameters\Paging;
use IIIF\Utils\ArrayCreator;
use IIIF\Utils\Validator;

/**
 * Implementation of an AnnotationList resource.
 * http://iiif.io/api/presentation/2.1/#annotation-list.
 */
class AnnotationList extends ResourceAbstract
{
    private $next;
    private $prev;
    private $startIndex;

    private $annotations = [];

    public $type = 'sc:AnnotationList';

    /**
     * Add an annotation.
     *
     * @param \IIIF\PresentationAPI\Resources\Annotation $annotation
     */
    public function addAnnotation(Annotation $annotation): void
    {
        array_push($this->annotations, $annotation);
    }

    /**
     * Get all annotations.
     *
     * @return array
     */
    public function getAnnotations()
    {
        return $this->annotations;
    }

    /**
     * Set the next property.
     *
     * @param string $next
     */
    public function setNext($next): void
    {
        $this->next = $next;
    }

    /**
     * Get the next property.
     *
     * @return string
     */
    public function getNext()
    {
        return $this->next;
    }

    /**
     * Set the prev property.
     *
     * @param string $prev
     */
    public function setPrev($prev): void
    {
        $this->prev = $prev;
    }

    /**
     * Get the prev property.
     *
     * @return string
     */
    public function getPrev()
    {
        return $this->prev;
    }

    /**
     * Set the startIndex.
     *
     * @param int $startIndex
     */
    public function setStartIndex($startIndex): void
    {
        Validator::greaterThanEqualZero($startIndex, 'The startIndex must be greater than zero');
        $this->startIndex = $startIndex;
    }

    /**
     * Get the startIndex.
     *
     * @return int
     */
    public function getStartIndex()
    {
        return $this->startIndex;
    }

    /**
     * {@inheritDoc}
     * @see \IIIF\PresentationAPI\Resources\ResourceAbstract::toArray()
     * @return array
     */
    public function toArray()
    {
        if ($this->getOnlyID()) {
            $id = $this->getID();
            Validator::itemExists($id, 'The id must be present in an Annotation List');
            return $id;
        }

        $array = [];

        /* Technical Properties **/
        if ($this->isTopLevel()) {
            ArrayCreator::addRequired($array, Identifier::CONTEXT, $this->getContexts(), 'The context must be present in an Annotation List');
        }
        ArrayCreator::addRequired($array, Identifier::ID, $this->getID(), 'The id must be present in an Annotation List');
        ArrayCreator::addRequired($array, Identifier::TYPE, $this->getType(), 'The type must be present in an Annotation List');
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

        /* Paging Properties **/
        ArrayCreator::addIfExists($array, Paging::NEXT, $this->getNext());
        ArrayCreator::addIfExists($array, Paging::PREVIOUS, $this->getPrev());
        ArrayCreator::addIfExists($array, Paging::STARTINDEX, $this->getStartIndex());

        /* Resource Types **/
        ArrayCreator::addIfExists($array, Identifier::RESOURCES, $this->getAnnotations());

        return $array;
    }
}
