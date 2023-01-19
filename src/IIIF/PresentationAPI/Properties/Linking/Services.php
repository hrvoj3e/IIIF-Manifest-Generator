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
 * @author   Tuva Solstad
 * @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 */

namespace IIIF\PresentationAPI\Properties\Linking;

use IIIF\PresentationAPI\ArrayableInterface;
use IIIF\PresentationAPI\Parameters\Identifier;
use IIIF\PresentationAPI\Traits\WithId;
use IIIF\PresentationAPI\Traits\WithLabel;
use IIIF\PresentationAPI\Traits\WithProfile;
use IIIF\PresentationAPI\Traits\WithService;
use IIIF\PresentationAPI\Traits\WithType;
use IIIF\Utils\ArrayCreator;

/**
 * Services linking property.
 * @link https://iiif.io/api/presentation/3.0/#services
 */
class Services implements ArrayableInterface
{
    use WithId;
    use WithLabel;
    use withProfile;
    use WithService;
    use withType;

    /**
     * Constructor.
     */
    public function __construct(string $id, string $type)
    {
        $this->id = $id;

        $this->type = $type;
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        $array = [];

        ArrayCreator::addRequired($array, Identifier::ID, $this->id, 'The id field is required');
        ArrayCreator::addRequired($array, Identifier::TYPE, $this->type, 'The type field is required');

        if (!empty($this->label)) {
            ArrayCreator::add($array, Identifier::LABEL, $this->label, false);
        }

        if (!empty($this->profile)) {
            ArrayCreator::add($array, Identifier::PROFILE, $this->profile, false);
        }

        if (!empty($this->service)) {
            ArrayCreator::add($array, Identifier::SERVICE, $this->service, false);
        }

        return $array;
    }
}
