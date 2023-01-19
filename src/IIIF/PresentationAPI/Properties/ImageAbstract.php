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
 * @package  Properties
 * @author   Harry Shyket <harry.shyket@yale.edu>
 * @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 */

namespace IIIF\PresentationAPI\Properties;

use IIIF\PresentationAPI\ArrayableInterface;
use IIIF\PresentationAPI\Parameters\Identifier;
use IIIF\PresentationAPI\Parameters\Type;
use IIIF\PresentationAPI\Traits\WithDimensions;
use IIIF\PresentationAPI\Traits\WithFormat;
use IIIF\PresentationAPI\Traits\WithId;
use IIIF\PresentationAPI\Traits\WithService;
use IIIF\Utils\ArrayCreator;

/**
 * Image resource.
 */
abstract class ImageAbstract implements ArrayableInterface
{
    use WithDimensions;
    use WithFormat;
    use WithId;
    use WithService;

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        $array = [];

        ArrayCreator::addRequired($array, Identifier::ID, $this->id, 'The id must be present in the image.');

        ArrayCreator::add($array, Identifier::TYPE, Type::IMAGE);

        if (!empty($this->format)) {
            ArrayCreator::add($array, Identifier::FORMAT, $this->format);
        }

        if (!empty($this->height)) {
            ArrayCreator::add($array, Identifier::HEIGHT, $this->height);
        }

        if (!empty($this->width)) {
            ArrayCreator::add($array, Identifier::WIDTH, $this->width);
        }

        if (!empty($this->service)) {
            ArrayCreator::add($array, Identifier::SERVICE, $this->service);
        }

        return $array;
    }
}
