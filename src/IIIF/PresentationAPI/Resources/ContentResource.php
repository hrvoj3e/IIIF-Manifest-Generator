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
use IIIF\PresentationAPI\Traits\WithDimensions;
use IIIF\PresentationAPI\Traits\WithDuration;
use IIIF\PresentationAPI\Traits\WithFormat;
use IIIF\PresentationAPI\Traits\WithLanguage;
use IIIF\PresentationAPI\Traits\WithProfile;
use IIIF\PresentationAPI\Traits\WithRotation;
use IIIF\PresentationAPI\Traits\WithType;
use IIIF\Utils\ArrayCreator;

/**
 * Content resource.
 * @link https://iiif.io/api/presentation/3.0/#57-content-resources
 */
class ContentResource extends ResourceAbstract
{
    use WithDimensions;
    use WithDuration;
    use WithFormat;
    use WithLanguage;
    use WithProfile;
    use WithRotation;
    use WithType;

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        $array = [];

        // Technical Properties

        ArrayCreator::addRequired($array, Identifier::ID, $this->getID(), 'The id must be present in a Content resource');
        ArrayCreator::addRequired($array, Identifier::TYPE, $this->type, 'The type must be present in a Content resource');

        if (!empty($this->format)) {
            ArrayCreator::add($array, Identifier::FORMAT, $this->format);
        }

        if (!empty($this->height)) {
            ArrayCreator::add($array, Identifier::HEIGHT, $this->height);
        }

        if (!empty($this->width)) {
            ArrayCreator::add($array, Identifier::WIDTH, $this->width);
        }

        if (!empty($this->rotation)) {
            ArrayCreator::add($array, Identifier::ROTATION, $this->rotation);
        }

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

        if (!empty($this->provider)) {
            ArrayCreator::add($array, Identifier::PROVIDER, $this->provider, false);
        }

        return [...$array, ...parent::toArray()];
    }
}
