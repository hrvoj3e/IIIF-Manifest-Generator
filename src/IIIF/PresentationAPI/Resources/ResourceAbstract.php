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
use IIIF\Utils\ArrayCreator;

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

    protected $onlyid         = false;
    protected $onlymemberdata = false;
    protected $defaultcontext = 'http://iiif.io/api/presentation/3/context.json';

    /**
     * Constructor.
     */
    public function __construct(
        string $id,
        protected bool $isTopLevel = false
    ) {
        $this->id = $id;

        if ($this->isTopLevel) {
            $this->addContext($this->getDefaultContext());
        }
    }

    /**
     * Set just the id to return instead of the class object.
     */
    public function returnOnlyID(): void
    {
        $this->onlyid = true;
    }

    /**
     * Check whether to only return the ID instead of the object.
     *
     * @return bool
     */
    public function getOnlyID()
    {
        return $this->onlyid;
    }

    /**
     * Usage when a resource only needs @id, @type and label.
     */
    public function returnOnlyMemberData(): void
    {
        $this->onlymemberdata = true;
    }

    /**
     * Return whether only certain data fields are needed.
     *
     * @return bool
     */
    public function getOnlyMemberData()
    {
        return $this->onlymemberdata;
    }

    /**
     * Is this the top level resource?
     */
    public function isTopLevel(): bool
    {
        return $this->isTopLevel;
    }

    /**
     * Returns the default context.
     */
    public function getDefaultContext()
    {
        return $this->defaultcontext;
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        $array = [];

        // Rights and Licensing Properties

        if (!empty($this->requiredStatement)) {
            ArrayCreator::add($array, Identifier::REQUIRED_STATEMENT, $this->requiredStatement);
        }

        if (!empty($this->rights)) {
            ArrayCreator::add($array, Identifier::RIGHTS, $this->rights);
        }

        // Technical Properties

        if (!empty($this->behavior)) {
            ArrayCreator::add($array, Identifier::BEHAVIOR, $this->behavior);
        }

        // Linking Properties

        if (!empty($this->homepage)) {
            ArrayCreator::add($array, Identifier::HOMEPAGE, $this->homepage, false);
        }

        if (!empty($this->rendering)) {
            ArrayCreator::add($array, Identifier::RENDERING, $this->rendering, false);
        }

        if (!empty($this->service)) {
            ArrayCreator::add($array, Identifier::SERVICE, $this->service, false);
        }

        if (!empty($this->seeAlso)) {
            ArrayCreator::add($array, Identifier::SEE_ALSO, $this->seeAlso, false);
        }

        if (!empty($this->partOf)) {
            ArrayCreator::add($array, Identifier::PART_OF, $this->partOf, false);
        }

        return $array;
    }
}
