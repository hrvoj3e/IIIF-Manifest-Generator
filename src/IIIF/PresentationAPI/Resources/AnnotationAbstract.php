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
 * Abstract annotation.
 * @link https://iiif.io/api/presentation/3.0/#56-annotation
 */
class AnnotationAbstract extends ResourceAbstract
{
    /**
     * Type.
     */
    protected const TYPE = null;

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        $array = [];

        // Technical Properties

        if ($this->isTopLevel()) {
            ArrayCreator::addRequired($array, Identifier::CONTEXT, $this->context, 'The context must be present in the Annotation');
        }

        ArrayCreator::addRequired($array, Identifier::ID, $this->id, 'The id must be present in the Annotation');
        ArrayCreator::addRequired($array, Identifier::TYPE, static::TYPE, 'The type must be present in the Annotation');

        // Descriptive Properties

        if (!empty($this->label)) {
            ArrayCreator::add($array, Identifier::LABEL, $this->label, true);
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

        return [...$array, ...parent::toArray()];
    }
}
