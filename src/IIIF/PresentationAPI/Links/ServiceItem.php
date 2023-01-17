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
 * @package  Links
 * @author   Harry Shyket <harry.shyket@yale.edu>
 * @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 */

namespace IIIF\PresentationAPI\Links;

/*
 * Implemenation for Service property.
 * https://iiif.io/api/presentation/3.0/#33-linking-properties.
 */
use IIIF\PresentationAPI\Parameters\Identifier;
use IIIF\Utils\ArrayCreator;

class ServiceItem extends LinkAbstract
{
    protected $context = 'http://iiif.io/api/image/3/context.json';

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        $item = [];

        ArrayCreator::addRequired($item, Identifier::ID, $this->id, 'The id must be present in a service');
        ArrayCreator::addRequired($item, Identifier::TYPE, $this->type, 'The type must be present in a service');
        ArrayCreator::addRequired($item, Identifier::PROFILE, $this->profile, 'The profile must be present in a service');

        return $item;
    }
}
