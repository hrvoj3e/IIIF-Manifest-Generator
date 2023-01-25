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
 * @category IIIF\PresentationAPI\Properties
 * @package  Linking
 * @author   Harry Shyket <harry.shyket@yale.edu>
 * @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 */

namespace IIIF\PresentationAPI\Properties\Linking;

use IIIF\PresentationAPI\ArrayableInterface;
use IIIF\PresentationAPI\LanguageStrings;
use IIIF\PresentationAPI\Parameters\Identifier;
use IIIF\PresentationAPI\Traits\WithFormat;
use IIIF\PresentationAPI\Traits\WithId;
use IIIF\PresentationAPI\Traits\WithLabel;
use IIIF\PresentationAPI\Traits\WithLanguage;
use IIIF\PresentationAPI\Traits\WithType;
use IIIF\Utils\ArrayCreator;

/**
 * Rendering linking property.
 * @link https://iiif.io/api/presentation/3.0/#rendering
 */
class Rendering implements ArrayableInterface
{
    use WithFormat;
    use WithId { setId as protected; }
    use WithLabel { setLabel as protected; }
    use WithLanguage;
    use WithType { setType as protected; }

    /**
     * Constructor.
     */
    public function __construct(string $id, string $type, LanguageStrings $label)
    {
        $this->id = $id;

        $this->type = $type;

        $this->label = $label;
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        $array = [];

        $array[Identifier::ID->value] = $this->id;

        $array[Identifier::TYPE->value] = $this->type;

        $array[Identifier::LABEL->value] = $this->label->toArray();

        if (!empty($this->format)) {
            $array[Identifier::FORMAT->value] = $this->format;
        }

        if (!empty($this->language)) {
            $array[Identifier::LANGUAGE->value] = $this->language;
        }

        return $array;
    }
}
