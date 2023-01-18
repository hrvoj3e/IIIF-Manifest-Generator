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
 * Implementation of a Collection resource.
 * @link https://iiif.io/api/presentation/3.0/#51-collection
 */
class Collection extends ResourceAbstract
{
    private $onlymemberdata = false;
    private $first;
    private $last;
    private $total;
    private $next;
    private $prev;
    private $startIndex;

    /* Sub collections of this collection. */
    private $collections = [];
    /* Manifests contained within collections. */
    private $manifests = [];
    /* Combination of manifests and collections.
     * Used where order is important */
    private $members = [];

    public $type = 'sc:Collection';

    /**
     * Add a collection to the collection.
     *
     * @param \IIIF\PresentationAPI\Resources\Collection $collection
     */
    public function addCollection(Collection $collection): void
    {
        array_push($this->collections, $collection);
    }

    /**
     * Get all of the collections.
     *
     * @return array
     */
    public function getCollections()
    {
        return $this->collections;
    }

    /**
     * Add a manifest to the collection.
     *
     * @param \IIIF\PresentationAPI\Resources\Manifest $manifest
     */
    public function addManifest(Manifest $manifest): void
    {
        array_push($this->manifests, $manifest);
    }

    /**
     * Get all of the manifests.
     *
     * @return array
     */
    public function getManifests()
    {
        return $this->manifests;
    }

    /**
     * Add a member to the collection.
     *
     * @param  \IIIF\PresentationAPI\Resources\Collection|\IIIF\PresentationAPI\Resources\Manifest $member
     * @throws \Exception
     */
    public function addMember($member): void
    {
        // Verify that the member being added is either a Collection or Manifest type.
        if (!($member instanceof Collection) && !($member instanceof Manifest)) {
            throw new \Exception('A Member of a Collection must either be a Collection or Manifest');
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
     * Set the first paging item.
     *
     * @param string $first
     */
    public function setFirst($first): void
    {
        $this->first = $first;
    }

    /**
     * Get the first item.
     *
     * @return string
     */
    public function getFirst()
    {
        return $this->first;
    }

    /**
     * Set the last paging item.
     *
     * @param string $last
     */
    public function setLast($last): void
    {
        $this->last = $last;
    }

    /**
     * Get the last paging item.
     *
     * @return string
     */
    public function getLast()
    {
        return $this->last;
    }

    /**
     * Set the total number of pages.
     *
     * @param int $total
     */
    public function setTotal($total): void
    {
        Validator::greaterThanEqualZero($total, 'The total must be a non-negative integer');
        $this->total = $total;
    }

    /**
     * Get the total number of page.
     *
     * @return int
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set the next page.
     *
     * @param string $next
     */
    public function setNext($next): void
    {
        $this->next = $next;
    }

    /**
     * Get the next page.
     *
     * @return string
     */
    public function getNext()
    {
        return $this->next;
    }

    /**
     * Set the previous page.
     *
     * @param string $prev
     */
    public function setPrev($prev): void
    {
        $this->prev = $prev;
    }

    /**
     * Get the previous page.
     *
     * @return string
     */
    public function getPrev()
    {
        return $this->prev;
    }

    /**
     * Set the start index.
     *
     * @param int $startIndex
     */
    public function setStartIndex($startIndex): void
    {
        Validator::greaterThanEqualZero($startIndex, 'The total must be a non-negative integer');
        $this->startIndex = $startIndex;
    }

    /**
     * Get the start index.
     *
     * @return int
     */
    public function getStartIndex()
    {
        return $this->startIndex;
    }

    /**
     * Make sure that the manifest is not embedded within the collection.
     *
     * @param \IIIF\PresentationAPI\Resources\Manifest $manifest
     */
    public function validateManifest(Manifest $manifest): void
    {
        $classname = '\IIIF\PresentationAPI\Resources\Manifest';
        $exclusions = [
            'getID',
            'getType',
            'getLabels',
            'getDefaultContext',
            'getOnlyMemberData',
        ];
        $message = 'A Manifest embedded within an Collection should only contain and id, type and label';
        Validator::shouldNotContainItems($manifest, $classname, $exclusions, $message);
    }

    /**
     * Make sure the collection within a memebr has viewingHint.
     *
     * @param \IIIF\PresentationAPI\Resources\Collection $collection
     */
    public function validateMemberCollection(Collection $collection): void
    {
        Validator::shouldContainItems($collection, ['getViewingHints'], 'The viewingHint must be present of a non top-level Collection');
    }

    /**
     * {@inheritDoc}
     *
     * @see \IIIF\PresentationAPI\Resources\ResourceAbstract::toArray()
     */
    public function toArray()
    {
        $array = [];

        if ($this->getOnlyMemberData()) {
            ArrayCreator::addRequired($array, Identifier::ID, $this->getID(), 'The id must be present in a Collection');
            ArrayCreator::addRequired($array, Identifier::TYPE, $this->getType(), 'The type must be present in a Collection');
            ArrayCreator::addRequired($array, Identifier::LABEL, $this->getLabels(), 'The label must be present in a Collection');

            if (!empty($this->behavior)) {
                ArrayCreator::add($array, Identifier::BEHAVIOR, $this->behavior);
            }

            return $array;
        }

        /* Technical Properties **/
        // If this is a top level item, then add the context
        if ($this->isTopLevel()) {
            ArrayCreator::addRequired($array, Identifier::CONTEXT, $this->getContexts(), 'The context must be present in the Collection');
        }
        ArrayCreator::addRequired($array, Identifier::ID, $this->getID(), 'The id must be present in the Collection');
        ArrayCreator::addRequired($array, Identifier::TYPE, $this->getType(), 'The type must be present in the Collection');

        if (!empty($this->behavior)) {
            ArrayCreator::add($array, Identifier::BEHAVIOR, $this->behavior);
        }

        ArrayCreator::addIfExists($array, Identifier::NAVDATE, $this->getNavDate());

        /* Descriptive Properties **/
        ArrayCreator::addRequired($array, Identifier::LABEL, $this->label, 'The label must be present in the Collection', false);
        ArrayCreator::addIfExists($array, Identifier::METADATA, $this->getMetadata());

        if (!empty($this->summary)) {
            ArrayCreator::add($array, Identifier::SUMMARY, $this->summary);
        }

        ArrayCreator::addIfExists($array, Identifier::THUMBNAIL, $this->getThumbnails());

        /* Rights and Licensing Properties **/

        if (!empty($this->requiredStatement)) {
            ArrayCreator::add($array, Identifier::REQUIRED_STATEMENT, $this->requiredStatement);
        }

        ArrayCreator::addIfExists($array, Identifier::RIGHTS, $this->rights);

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
        ArrayCreator::addIfExists($array, Paging::FIRST, $this->getFirst());
        ArrayCreator::addIfExists($array, Paging::LAST, $this->getLast());
        ArrayCreator::addIfExists($array, Paging::TOTAL, $this->getTotal());
        ArrayCreator::addIfExists($array, Paging::NEXT, $this->getNext());
        ArrayCreator::addIfExists($array, Paging::PREVIOUS, $this->getPrev());
        ArrayCreator::addIfExists($array, Paging::STARTINDEX, $this->getStartIndex());

        /* Resource Types **/
        ArrayCreator::addIfExists($array, Identifier::COLLECTIONS, $this->getCollections(), false);
        // Validate the manifests
        foreach ($this->getManifests() as $manifest) {
            $this->validateManifest($manifest);
        }
        ArrayCreator::addIfExists($array, Identifier::MANIFESTS, $this->getManifests(), false);
        // Validate the manifests in the members
        foreach ($this->getMembers() as $member) {
            if ($member instanceof Manifest) {
                $this->validateManifest($member);
            } elseif ($member instanceof Collection) {
                $this->validateMemberCollection($member);
            } else {
            }
        }
        ArrayCreator::addIfExists($array, Identifier::MEMBERS, $this->getMembers(), false);

        return $array;
    }
}
