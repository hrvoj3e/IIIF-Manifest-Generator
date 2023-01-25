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
use IIIF\PresentationAPI\Traits\WithDimensions;
use IIIF\PresentationAPI\Traits\WithDuration;
use IIIF\PresentationAPI\Traits\WithItems;
use IIIF\Utils\ArrayCreator;
use IIIF\Utils\Validator;

/**
 * Canvas resource.
 * @link https://iiif.io/api/presentation/3.0/#53-canvas
 */
class Canvas extends ResourceAbstract
{
    use WithAnnotations;
    use WithDimensions { setHeight as protected;
        setWidth as protected; }
    use WithDuration;
    use WithItems;

    /**
     * Type.
     */
    protected const TYPE = 'Canvas';

    /**
     * Set dimensions.
     */
    public function setDimensions(int $height, int $width): void
    {
        $this->setHeight($height);
        $this->setWidth($width);
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        if ($this->getOnlyId()) {
            $id = $this->id;
            Validator::itemExists($id, 'The id must be present in the Canvas');
            return $id;
        }

        $array = [];

        if ($this->getOnlyMemberData()) {
            ArrayCreator::addRequired($array, Identifier::ID, $this->id, 'The id must be present in the Canvas');
            ArrayCreator::addRequired($array, Identifier::TYPE, static::TYPE, 'The type must be present in the Canvas');

            if (!empty($this->label)) {
                ArrayCreator::add($array, Identifier::LABEL, $this->label, false);
            }

            return $array;
        }

        // Technical Properties

        ArrayCreator::addRequired($array, Identifier::ID, $this->id, 'The id must be present in the Canvas');
        ArrayCreator::addRequired($array, Identifier::TYPE, static::TYPE, 'The type must be present in the Canvas');

        if ($this->isTopLevel) {
            ArrayCreator::addRequired($array, Identifier::CONTEXT, $this->context, 'The context must be present in the Canvas');
        }

        if (!empty($this->duration)) {
            ArrayCreator::add($array, Identifier::DURATION, $this->duration);
        }

        if (!empty($this->height)) {
            ArrayCreator::add($array, Identifier::HEIGHT, $this->height);
        }

        if (!empty($this->width)) {
            ArrayCreator::add($array, Identifier::WIDTH, $this->width);
        }

        // Descriptive Properties

        if (!empty($this->label)) {
            ArrayCreator::add($array, Identifier::LABEL, $this->label, false);
        }

        if (!empty($this->metadata)) {
            ArrayCreator::add($array, Identifier::METADATA, $this->metadata, false);
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

        // Structural Properties

        if (!empty($this->items)) {
            ArrayCreator::add($array, Identifier::ITEMS, $this->items, false);
        }

        if (!empty($this->annotations)) {
            ArrayCreator::add($array, Identifier::ANNOTATIONS, $this->annotations, false);
        }

        return [...$array, ...parent::toArray()];
    }
}
