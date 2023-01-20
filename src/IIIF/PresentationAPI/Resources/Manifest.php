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
use IIIF\PresentationAPI\Traits\WithAnnotations;
use IIIF\PresentationAPI\Traits\WithItems;
use IIIF\PresentationAPI\Traits\WithNavDate;
use IIIF\PresentationAPI\Traits\WithServices;
use IIIF\PresentationAPI\Traits\WithStart;
use IIIF\PresentationAPI\Traits\WithViewingDirection;
use IIIF\Utils\ArrayCreator;
use IIIF\Utils\Validator;
use JsonSerializable;

use function count;

/**
 * Implementation of a Manifest resource.
 * @link https://iiif.io/api/presentation/3.0/#52-manifest
 */
class Manifest extends ResourceAbstract implements JsonSerializable
{
    use WithAnnotations;
    use WithItems;
    use WithNavDate;
    use WithServices;
    use WithStart;
    use WithViewingDirection;

    /**
     * Type.
     */
    protected const TYPE = 'Manifest';

    protected $sequences = [];
    protected $structures = [];

    /**
     * Add a sequence to the manifest.
     *
     * @param \IIIF\PresentationAPI\Resources\Sequence $sequence
     */
    public function addSequence(Sequence $sequence): void
    {
        if (count($this->sequences) >= 1) {
            $sequence->returnOnlyMemberData();
        }

        $this->sequences[] = $sequence;
    }

    /**
     * Get all of the sequences.
     *
     * @return array
     */
    public function getSequences()
    {
        return $this->sequences;
    }

    /**
     * Add a range.
     *
     * @param \IIIF\PresentationAPI\Resources\Range $range
     */
    public function addStructure(Range $range): void
    {
        $this->structures[] = $range;
    }

    /**
     * Get the structures (ranges).
     *
     * @return array
     */
    public function getStructures()
    {
        return $this->structures;
    }

    /**
     * Make sure the sequence is valid.
     *
     * @param \IIIF\PresentationAPI\Resources\Sequence $sequence
     */
    public function validateSequence(Sequence $sequence): void
    {
        $classname = Sequence::class;

        $exclusions = [
            'getID',
            'getType',
            'getLabels',
            'getDefaultContext',
            'getOnlyMemberData',
        ];

        $message = 'A Sequence after the first one embedded within a Manifest should only contain an id, type and label';

        Validator::shouldNotContainItems($sequence, $classname, $exclusions, $message);

        Validator::shouldContainItems($sequence, ['getLabels'], 'Multiple Sequences within a Manifest must contain a label');
    }

    /**
     * Make sure the annotation list is valid.
     *
     * @param AnnotationList $annotationlist
     */
    public function validateAnnotationList(AnnotationList $annotationlist): void
    {
        $classname = AnnotationList::class;

        $exclusions = [
            'getID',
            'getType',
            'getLabels',
            'getDefaultContext',
            'getWithin',
        ];

        $message = 'An Annotation List must not be embedded in a Manifest';

        Validator::shouldNotContainItems($annotationlist, $classname, $exclusions, $message);
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        $array = [];

        if ($this->getOnlyMemberData()) {
            ArrayCreator::addRequired($array, Identifier::ID, $this->id, 'The id must be present in a Manifest');
            ArrayCreator::addRequired($array, Identifier::TYPE, static::TYPE, 'The type must be present in a Manifest');
            ArrayCreator::addRequired($array, Identifier::LABEL, $this->label, 'The label must be present in a Manifest');

            return $array;
        }

        // Technical Properties

        if ($this->isTopLevel) {
            ArrayCreator::addRequired($array, Identifier::CONTEXT, $this->context, 'The context must be present in the Manifest');
        }

        ArrayCreator::addRequired($array, Identifier::ID, $this->id, 'The id must be present in the Manifest');
        ArrayCreator::addRequired($array, Identifier::TYPE, static::TYPE, 'The type must be present in the Manifest');

        if (!empty($this->viewingDirection)) {
            ArrayCreator::add($array, Identifier::VIEWING_DIRECTION, $this->viewingDirection->value);
        }

        if (!empty($this->navDate)) {
            ArrayCreator::add($array, Identifier::NAVDATE, $this->navDate->format(static::NAV_DATE_FORMAT));
        }

        // Descriptive Properties

        ArrayCreator::addRequired($array, Identifier::LABEL, $this->label, 'The label must be present in the Manifest', false);

        if (!empty($this->metadata)) {
            ArrayCreator::add($array, Identifier::METADATA, $this->metadata);
        }

        if (!empty($this->summary)) {
            ArrayCreator::add($array, Identifier::SUMMARY, $this->summary);
        }

        if (!empty($this->thumbnail)) {
            ArrayCreator::add($array, Identifier::THUMBNAIL, $this->thumbnail, false);
        }

        if (!empty($this->provider)) {
            ArrayCreator::add($array, Identifier::PROVIDER, $this->provider, false);
        }

        //  Linking Properties

        if (!empty($this->services)) {
            ArrayCreator::add($array, Identifier::SERVICES, $this->services, false);
        }

        if (!empty($this->start)) {
            ArrayCreator::add($array, Identifier::START, $this->start, false);
        }

        // Structural properties

        if (!empty($this->items)) {
            ArrayCreator::add($array, Identifier::ITEMS, $this->items, false);
        }

        if (!empty($this->annotations)) {
            ArrayCreator::add($array, Identifier::ANNOTATIONS, $this->annotations, false);
        }

        // Resource Types

        if ($this->isTopLevel) {
            /*foreach ($this->sequences as $key => $sequence) {
                if ($key > 0) {
                    $this->validateSequence($sequence);
                }

                foreach ($sequence->getCanvases() as $canvases) {
                    foreach ($canvases->getOtherContents() as $annotationlist) {
                        $this->validateAnnotationList($annotationlist);
                    }
                }
            }

            ArrayCreator::addRequired($array, Identifier::SEQUENCES, $this->sequences, "The first Sequence must be embedded within a Manifest", false);*/

            if (!empty($this->structures)) {
                ArrayCreator::add($array, Identifier::STRUCTURES, $this->structures, false);
            }
        } else {
            if (!empty($this->sequences)) {
                ArrayCreator::add($array, Identifier::SEQUENCES, $this->sequences, false);
            }

            if (!empty($this->structures)) {
                ArrayCreator::add($array, Identifier::STRUCTURES, $this->structures, false);
            }
        }

        return [...$array, ...parent::toArray()];
    }

    /**
     * {@inheritDoc}
     */
    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }
}
