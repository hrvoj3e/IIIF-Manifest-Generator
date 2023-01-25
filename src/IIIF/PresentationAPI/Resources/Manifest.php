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

use IIIF\PresentationAPI\LanguageStrings;
use IIIF\PresentationAPI\Parameters\Identifier;
use IIIF\PresentationAPI\Traits\WithAnnotations;
use IIIF\PresentationAPI\Traits\WithItems;
use IIIF\PresentationAPI\Traits\WithNavDate;
use IIIF\PresentationAPI\Traits\WithServices;
use IIIF\PresentationAPI\Traits\WithStart;
use IIIF\PresentationAPI\Traits\WithViewingDirection;
use IIIF\Utils\Validator;
use JsonSerializable;
use RuntimeException;

use function array_map;
use function count;

/**
 * Manifest resource.
 * @link https://iiif.io/api/presentation/3.0/#52-manifest
 *
 * @property \IIIF\PresentationAPI\Resources\Annotation[] $items
 */
class Manifest extends ResourceAbstract implements JsonSerializable
{
    use WithAnnotations;
    use WithItems { addItem as protected addAnyItem; }
    use WithNavDate;
    use WithServices;
    use WithStart;
    use WithViewingDirection;

    /**
     * Type.
     */
    protected const TYPE = 'Manifest';

    //protected $sequences = [];
    //protected $structures = [];

    /**
     * Constructor.
     */
    public function __construct(string $id, LanguageStrings $label, bool $isTopLevel = false)
    {
        $this->label = $label;

        parent::__construct($id, $isTopLevel);
    }

    /**
     * Add an item.
     */
    public function addItem(Canvas $item): void
    {
        $this->addAnyItem($item);
    }

    /**
     * Add a sequence to the manifest.
     *
     * @param \IIIF\PresentationAPI\Resources\Sequence $sequence
     */
    /*public function addSequence(Sequence $sequence): void
    {
        if (count($this->sequences) >= 1) {
            $sequence->returnOnlyMemberData();
        }

        $this->sequences[] = $sequence;
    }*/

    /**
     * Get all of the sequences.
     *
     * @return array
     */
    /*public function getSequences()
    {
        return $this->sequences;
    }*/

    /**
     * Add a range.
     *
     * @param \IIIF\PresentationAPI\Resources\Range $range
     */
    /*public function addStructure(Range $range): void
    {
        $this->structures[] = $range;
    }*/

    /**
     * Get the structures (ranges).
     *
     * @return array
     */
    /*public function getStructures()
    {
        return $this->structures;
    }*/

    /**
     * Make sure the sequence is valid.
     *
     * @param \IIIF\PresentationAPI\Resources\Sequence $sequence
     */
    /*public function validateSequence(Sequence $sequence): void
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
    }*/

    /**
     * Make sure the annotation list is valid.
     *
     * @param AnnotationList $annotationlist
     */
    /*public function validateAnnotationList(AnnotationList $annotationlist): void
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
    }*/

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        $array = [];

        if ($this->isTopLevel && !$this->onlyMemberData) {
            $array[Identifier::CONTEXT->value] = count($this->context) > 1 ? $this->context : $this->context[0];
        }

        $array[Identifier::ID->value] = $this->id;
        $array[Identifier::TYPE->value] = static::TYPE;
        $array[Identifier::LABEL->value] = $this->label->toArray();

        if ($this->onlyMemberData) {
            return $array;
        }

        if (empty($this->items)) {
            throw new RuntimeException('A manifest must have at least one item.');
        }

        // Technical Properties

        if (!empty($this->viewingDirection)) {
            $array[Identifier::VIEWING_DIRECTION->value] = $this->viewingDirection->value;
        }

        if (!empty($this->navDate)) {
            $array[Identifier::NAVDATE->value] = $this->navDate->format(static::NAV_DATE_FORMAT);
        }

        // Descriptive Properties

        if (!empty($this->metadata)) {
            $array[Identifier::METADATA->value] = $this->metadata->toArray();
        }

        if (!empty($this->summary)) {
            $array[Identifier::SUMMARY->value] = $this->summary->toArray();
        }

        if (!empty($this->thumbnail)) {
            $array[Identifier::THUMBNAIL->value] = array_map(fn ($thumbnail) => $thumbnail->toArray(), $this->thumbnail);
        }

        if (!empty($this->provider)) {
            $array[Identifier::PROVIDER->value] = $this->provider->toArray();
        }

        //  Linking Properties

        if (!empty($this->services)) {
            $array[Identifier::SERVICES->value] = array_map(fn ($service) => $service->toArray(), $this->services);
        }

        if (!empty($this->start)) {
            $array[Identifier::START->value] = $this->start->toArray();
        }

        // Structural properties

        $array[Identifier::ITEMS->value] = array_map(fn ($item) => $item->toArray(), $this->items);

        if (!empty($this->annotations)) {
            $array[Identifier::ANNOTATIONS->value] = array_map(fn ($annotation) => $annotation->toArray(), $this->annotations);
        }

        // Resource Types

        /*if ($this->isTopLevel) {
            foreach ($this->sequences as $key => $sequence) {
                if ($key > 0) {
                    $this->validateSequence($sequence);
                }

                foreach ($sequence->getCanvases() as $canvases) {
                    foreach ($canvases->getOtherContents() as $annotationlist) {
                        $this->validateAnnotationList($annotationlist);
                    }
                }
            }

            ArrayCreator::addRequired($array, Identifier::SEQUENCES, $this->sequences, "The first Sequence must be embedded within a Manifest", false);

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
        }*/

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
