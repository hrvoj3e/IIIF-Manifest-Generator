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

use IIIF\PresentationAPI\Links\Service;
use IIIF\PresentationAPI\Parameters\Identifier;
use IIIF\Utils\ArrayCreator;

/**
 * Implementation for descriptive property resources.
 */
abstract class MimeAbstract extends PropertyAbstract
{
    private $service;

    /**
     * {@inheritDoc}
     * @see \IIIF\PresentationAPI\Properties\PropertyInterface::setService()
     * @param \IIIF\PresentationAPI\Links\Service
     */
    public function setService(Service $service): void
    {
        $this->service = $service;
    }

    /**
     * {@inheritDoc}
     */
    public function getService(): Service
    {
        return $this->service;
    }

    public function toArray()
    {
        $array = [];

        ArrayCreator::addRequired($array, Identifier::ID, $this->getID(), 'The id must be present in the thumbnail');
        ArrayCreator::addIfExists($array, Identifier::SERVICE, $this->getService());

        return $array;
    }
}
