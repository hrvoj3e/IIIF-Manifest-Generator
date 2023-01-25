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

use IIIF\PresentationAPI\ArrayableInterface;
use IIIF\PresentationAPI\Parameters\Identifier;
use IIIF\PresentationAPI\Traits\WithBehavior;
use IIIF\PresentationAPI\Traits\WithContext;
use IIIF\PresentationAPI\Traits\WithHomepage;
use IIIF\PresentationAPI\Traits\WithId;
use IIIF\PresentationAPI\Traits\WithLabel;
use IIIF\PresentationAPI\Traits\WithMetadata;
use IIIF\PresentationAPI\Traits\WithPartOf;
use IIIF\PresentationAPI\Traits\WithProvider;
use IIIF\PresentationAPI\Traits\WithRendering;
use IIIF\PresentationAPI\Traits\WithRequiredStatement;
use IIIF\PresentationAPI\Traits\WithRights;
use IIIF\PresentationAPI\Traits\WithSeeAlso;
use IIIF\PresentationAPI\Traits\WithService;
use IIIF\PresentationAPI\Traits\WithSummary;
use IIIF\PresentationAPI\Traits\WithThumbnail;

/**
 * Abstract resource.
 */
abstract class ResourceAbstract implements ArrayableInterface
{
    use WithBehavior;
    use WithContext;
    use WithHomepage;
    use WithId { setId as protected; }
    use WithLabel;
    use WithMetadata;
    use WithPartOf;
    use WithProvider;
    use WithRendering;
    use WithRequiredStatement;
    use WithRights;
    use WithSeeAlso;
    use WithService;
    use WithSummary;
    use WithThumbnail;

    protected $onlyId         = false;
    protected $onlyMemberData = false;
    protected $defaultContext = 'http://iiif.io/api/presentation/3/context.json';

    /**
     * Constructor.
     */
    public function __construct(
        string $id,
        protected bool $isTopLevel = false
    ) {
        $this->id = $id;

        if ($this->isTopLevel) {
            $this->addContext($this->defaultContext);
        }
    }

    /**
     * Set just the id to return instead of the class object.
     */
    public function returnOnlyId(): void
    {
        $this->onlyId = true;
    }

    /**
     * Check whether to only return the ID instead of the object.
     */
    public function getOnlyId(): bool
    {
        return $this->onlyId;
    }

    /**
     * Usage when a resource only needs id, type and label.
     */
    public function returnOnlyMemberData(): void
    {
        $this->onlyMemberData = true;
    }

    /**
     * Return whether only certain data fields are needed.
     */
    public function getOnlyMemberData(): bool
    {
        return $this->onlyMemberData;
    }

    /**
     * Is this the top level resource?
     */
    public function isTopLevel(): bool
    {
        return $this->isTopLevel;
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        $array = [];

        // Rights and Licensing Properties

        if (!empty($this->requiredStatement)) {
            $array[Identifier::REQUIRED_STATEMENT->value] = $this->requiredStatement->toArray();
        }

        if (!empty($this->rights)) {
            $array[Identifier::RIGHTS->value] = $this->rights;
        }

        // Technical Properties

        if (!empty($this->behavior)) {
            $array[Identifier::BEHAVIOR->value] = $this->behavior->toArray();
        }

        // Linking Properties

        if (!empty($this->homepage)) {
            $array[Identifier::HOMEPAGE->value] = array_map(fn ($homepage) => $homepage->toArray(), $this->homepage);
        }

        if (!empty($this->rendering)) {
            $array[Identifier::RENDERING->value] = array_map(fn ($rendering) => $rendering->toArray(), $this->rendering);
        }

        if (!empty($this->service)) {
            $array[Identifier::SERVICE->value] = $this->service->toArray();
        }

        if (!empty($this->seeAlso)) {
            $array[Identifier::SEE_ALSO->value] = array_map(fn ($seeAlso) => $seeAlso->toArray(), $this->seeAlso);
        }

        if (!empty($this->partOf)) {
            $array[Identifier::PART_OF->value] = array_map(fn ($partOf) => $partOf->toArray(), $this->partOf);
        }

        return $array;
    }
}
