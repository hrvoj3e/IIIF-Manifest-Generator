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
 *  @package  Resources
 *  @author   Harry Shyket <harry.shyket@yale.edu>
 *  @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
*/

namespace IIIF\PresentationAPI\Resources;

use IIIF\PresentationAPI\Parameters\Identifier;
use IIIF\Utils\ArrayCreator;
use IIIF\Utils\Validator;

use function count;

/**
 * Implementation of a Manifest resource.
 * http://iiif.io/api/presentation/2.1/#manifest.
 */
class Manifest extends ResourceAbstract
{
    protected $sequences = [];
    protected $structures = [];
    protected $type = 'Manifest';

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
     * @see \IIIF\PresentationAPI\Resources\ResourceAbstract::toArray()
     */
    public function toArray()
    {
        $item = [];

        if ($this->getOnlyMemberData()) {
            ArrayCreator::addRequired($item, Identifier::ID, $this->id, 'The id must be present in a Manifest');
            ArrayCreator::addRequired($item, Identifier::TYPE, $this->type, 'The type must be present in a Manifest');
            ArrayCreator::addRequired($item, Identifier::LABEL, $this->labels, 'The label must be present in a Manifest');

            return $item;
        }

        // Technical Properties

        if ($this->isTopLevel()) {
            ArrayCreator::addRequired($item, Identifier::CONTEXT, $this->contexts, 'The context must be present in the Manifest');
        }

        ArrayCreator::addRequired($item, Identifier::ID, $this->id, 'The id must be present in the Manifest');
        ArrayCreator::addRequired($item, Identifier::TYPE, $this->type, 'The type must be present in the Manifest');

        if (!empty($this->viewinghints)) {
            ArrayCreator::add($item, Identifier::VIEWINGHINT, $this->viewinghints);
        }

        if (!empty($this->viewingdirection)) {
            ArrayCreator::add($item, Identifier::VIEWINGDIRECTION, $this->viewingdirection);
        }

        if (!empty($this->navdate)) {
            ArrayCreator::add($item, Identifier::NAVDATE, $this->navdate);
        }

        // Descriptive Properties

        ArrayCreator::addRequired($item, Identifier::LABEL, $this->labels, 'The label must be present in the Manifest');

        if (!empty($this->metadata)) {
            ArrayCreator::add($item, Identifier::METADATA, $this->metadata);
        }

        if (!empty($this->descriptions)) {
            ArrayCreator::add($item, Identifier::DESCRIPTION, $this->descriptions);
        }

        if (!empty($this->thumbnails)) {
            ArrayCreator::add($item, Identifier::THUMBNAIL, [$this->thumbnails]);
        }

        // Rights and Licensing Properties

        if (!empty($this->licenses)) {
            ArrayCreator::add($item, Identifier::LICENSE, $this->licenses);
        }

        if (!empty($this->attributions)) {
            ArrayCreator::add($item, Identifier::ATTRIBUTION, $this->attributions);
        }

        if (!empty($this->logos)) {
            ArrayCreator::add($item, Identifier::LOGO, $this->logos);
        }

        //  Linking Properties

        if (!empty($this->related)) {
            ArrayCreator::add($item, Identifier::RELATED, $this->related);
        }

        if (!empty($this->rendering)) {
            ArrayCreator::add($item, Identifier::RENDERING, $this->rendering);
        }

        if (!empty($this->services)) {
            ArrayCreator::add($item, Identifier::SERVICE, $this->services);
        }

        if (!empty($this->seealso)) {
            ArrayCreator::add($item, Identifier::SEEALSO, $this->seealso);
        }

        if (!empty($this->within)) {
            ArrayCreator::add($item, Identifier::WITHIN, $this->within);
        }

        // Resource Types

        if ($this->isTopLevel()) {
            $x = 1;
            foreach ($this->sequences as $sequence) {
                // Skip first sequence
                if ($x > 1) {
                    $this->validateSequence($sequence);
                }
                $x++;
                foreach ($sequence->getCanvases() as $canvases) {
                    foreach ($canvases->getOtherContents() as $annotationlist) {
                        $this->validateAnnotationList($annotationlist);
                    }
                }
            }

            //ArrayCreator::addRequired($item, Identifier::SEQUENCES, $this->getSequences(), "The first Sequence must be embedded within a Manifest", false);

            if (!empty($this->structures)) {
                ArrayCreator::add($item, Identifier::STRUCTURES, $this->structures, false);
            }
        } else {
            if (!empty($this->sequences)) {
                ArrayCreator::add($item, Identifier::SEQUENCES, $this->sequences, false);
            }

            if (!empty($this->structures)) {
                ArrayCreator::addIfExists($item, Identifier::STRUCTURES, $this->structures, false);
            }
        }

        return $item;
    }
}
