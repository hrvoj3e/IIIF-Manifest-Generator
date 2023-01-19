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
 * @package  Traits
 * @author   Tuva Solstad
 * @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 */

namespace IIIF\PresentationAPI\Traits;

use IIIF\PresentationAPI\Properties\Linking\PartOf;

trait WithPartOf
{
    /**
     * PartOfs.
     *
     * @var PartOf[]
     */
    protected array $partOf = [];

    /**
     * Add a partOf.
     */
    public function addPartOf(PartOf $partOf): void
    {
        $this->partOf[] = $partOf;
    }

    /**
     * Returns the partOf.
     *
     * @return PartOf[]
     */
    public function getPartOf(): ?array
    {
        return $this->partOf;
    }
}
