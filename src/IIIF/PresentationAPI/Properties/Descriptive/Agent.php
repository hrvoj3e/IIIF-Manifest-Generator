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

        ArrayCreator::addRequired($array, Identifier::ID, $this->id, 'The id field is required');
        ArrayCreator::addRequired($array, Identifier::TYPE, static::TYPE, 'The type field is required');
        ArrayCreator::addRequired($array, Identifier::LABEL, $this->label, 'The label field is required');

        if (!empty($this->homepage)) {
            ArrayCreator::add($array, Identifier::HOMEPAGE, $this->homepage, false);
        }

        if (!empty($this->logo)) {
            ArrayCreator::add($array, Identifier::LOGO, $this->logo, false);
        }

        if (!empty($this->seeAlso)) {
            ArrayCreator::add($array, Identifier::SEE_ALSO, $this->seeAlso, false);
        }

        return $array;
    }
}
