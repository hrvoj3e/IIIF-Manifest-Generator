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
 *  @category IIIF
 *  @author   Harry Shyket <harry.shyket@yale.edu>
 *  @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
*/

namespace IIIF;

use IIIF\PresentationAPI\Links\LinkInterface;
use IIIF\PresentationAPI\Metadata\MetadataInterface;
use IIIF\PresentationAPI\Properties\PropertyInterface;
use IIIF\PresentationAPI\Resources\ResourceInterface;

use function json_encode;

class Generator
{
    /**
     * Generate the manifest file.
     * @param LinkInterface|MetadataInterface|PropertyInterface|ResourceInterface $item
     * @param string                                                              $location
     */
    public function generate($item)
    {
        return json_encode($item->toArray(), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }
}
