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
 * @package  Descriptive
 * @author   Harry Shyket <harry.shyket@yale.edu>
 * @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 */

namespace IIIF\PresentationAPI\Properties\Descriptive;

use IIIF\PresentationAPI\ArrayableInterface;
use IIIF\PresentationAPI\LanguageStrings;
use IIIF\PresentationAPI\Parameters\Identifier;
use IIIF\PresentationAPI\Traits\WithHomepage;
use IIIF\PresentationAPI\Traits\WithId;
use IIIF\PresentationAPI\Traits\WithLabel;
use IIIF\PresentationAPI\Traits\WithLogo;
use IIIF\PresentationAPI\Traits\WithSeeAlso;
use IIIF\Utils\ArrayCreator;

/**
 * Agent descriptive property.
 * @link https://iiif.io/api/presentation/3.0/#provider
 */
class Agent implements ArrayableInterface
{
    use WithHomepage;
    use WithId { setId as protected; }
    use WithLabel { setLabel as protected; }
    use WithLogo;
    use WithSeeAlso;

    /**
     * Type.
     */
    protected const TYPE = 'Agent';

    /**
     * Constructor.
     */
    public function __construct(string $id, LanguageStrings $label)
    {
        $this->id = $id;

        $this->label = $label;
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        $array = [];

        $array[Identifier::ID->value] = $this->id;

        $array[Identifier::TYPE->value] = static::TYPE;

        $array[Identifier::LABEL->value] = $this->label->toArray();

        if (!empty($this->homepage)) {
            $array[Identifier::HOMEPAGE->value] = array_map(fn ($homepage) => $homepage->toArray(), $this->homepage);
        }

        if (!empty($this->logo)) {
            $array[Identifier::LOGO->value] = array_map(fn ($logo) => $logo->toArray(), $this->logo);
        }

        if (!empty($this->seeAlso)) {
            $array[Identifier::SEE_ALSO->value] = array_map(fn ($seeAlso) => $seeAlso->toArray(), $this->seeAlso);
        }

        return $array;
    }
}
