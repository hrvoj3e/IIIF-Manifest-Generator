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

use DateTimeInterface;
use IIIF\PresentationAPI\LabelValueItem;
use IIIF\PresentationAPI\LanguageStrings;
use IIIF\PresentationAPI\Links\SeeAlso;
use IIIF\PresentationAPI\Properties\Descriptive\Metadata;
use IIIF\PresentationAPI\Properties\Descriptive\Thumbnail;
use IIIF\PresentationAPI\Properties\Linking\Logo;
use IIIF\PresentationAPI\Properties\Technical\Behavior;
use IIIF\PresentationAPI\Traits\WithHomepage;
use IIIF\PresentationAPI\Traits\WithPartOf;
use IIIF\PresentationAPI\Traits\WithRendering;
use IIIF\PresentationAPI\Traits\WithService;
use IIIF\PresentationAPI\Traits\WithViewingDirection;
use IIIF\Utils\Validator;

use function count;

/**
 * Abstract implementation of a resource.
 */
abstract class ResourceAbstract
{
    use WithHomepage;
    use WithPartOf;
    use WithRendering;
    use WithService;
    use WithViewingDirection;

    protected $id;
    protected $onlyid         = false;
    protected $onlymemberdata = false;
    protected $type;
    protected $defaultcontext = 'http://iiif.io/api/presentation/3/context.json';
    protected $navdate;
    protected $contexts                              = [];
    protected $label                                 = [];
    protected Behavior|null $behavior                = null;
    protected $summary                               = null;
    protected LabelValueItem|null $requiredStatement = null;
    protected string|null $rights                    = null;
    protected $thumbnails                            = [];
    protected $logos                                 = [];
    protected $metadata                              = [];
    protected array $seeAlso                         = [];

    /**
     * Constructor.
     */
    public function __construct(
        protected bool $isTopLevel = false
    ) {
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
     * {@inheritDoc}
     * @see \IIIF\PresentationAPI\Resources\ResourceInterface::isTopLevel()
     * @return bool
     */
    public function isTopLevel(): bool
    {
        return $this->isTopLevel;
    }

    /**
     * {@inheritDoc}
     * @see \IIIF\PresentationAPI\Resources\ResourceInterface::addContext()
     * @param string
     */
    public function addContext($context): void
    {
        $this->contexts[] = $context;
    }

    /**
     * {@inheritDoc}
     * @see \IIIF\PresentationAPI\Resources\ResourceInterface::getContext()
     * @return array
     */
    public function getContexts()
    {
        if (count($this->contexts) == 1) {
            return $this->contexts[0];
        }

        return $this->contexts;
    }

    /**
     * {@inheritDoc}
     * @see \IIIF\PresentationAPI\Resources\ResourceInterface::getDefaultContext()
     * @return string
     */
    public function getDefaultContext()
    {
        return $this->defaultcontext;
    }

    /**
     * {@inheritDoc}
     * @see \IIIF\PresentationAPI\Resources\ResourceInterface::setID()
     * @param string
     */
    public function setID($id): void
    {
        $this->id = $id;
    }

    /**
     * {@inheritDoc}
     * @see \IIIF\PresentationAPI\Resources\ResourceInterface::getID()
     * @return string
     */
    public function getID()
    {
        return $this->id;
    }

    /**
     * {@inheritDoc}
     * @see \IIIF\PresentationAPI\Resources\ResourceInterface::getType()
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * {@inheritDoc}
     * @param array|string $label
     * @param string       $language
     */
    public function setLabel(LanguageStrings $languageStrings): void
    {
        $this->label = $languageStrings->toArray();
    }

    /**
     * {@inheritDoc}
     * @see \IIIF\PresentationAPI\Resources\ResourceInterface::getLabelss()
     * @return array
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * {@inheritDoc}
     */
    public function setBehavior(Behavior $behavior): void
    {
        $this->behavior = $behavior;
    }

    /**
     * {@inheritDoc}
     */
    public function getBehavior(): Behavior
    {
        return $this->behavior;
    }

    /**
     * {@inheritDoc}
     */
    public function setSummary(LanguageStrings $languageStrings): void
    {
        $this->summary = $languageStrings;
    }

    /**
     * {@inheritDoc}
     */
    public function getSummary(): LanguageStrings
    {
        return $this->summary;
    }

    /**
     * {@inheritDoc}
     */
    public function setRequiredStatement(LabelValueItem $labelValueItem): void
    {
        $this->requiredStatement = $labelValueItem;
    }

    /**
     * {@inheritDoc}
     */
    public function getRequiredStatement(): ?LabelValueItem
    {
        return $this->requiredStatement;
    }

    /**
     * {@inheritDoc}
     */
    public function setRights(string $rights): void
    {
        // Make sure it is a valid URL
        if (Validator::validateURL($rights, 'The license must be a valid URL')) {
            $this->rights = $rights;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getRights(): ?string
    {
        return $this->rights;
    }

    /**
     * {@inheritDoc}
     */
    public function addThumbnail(Thumbnail $thumbnail): void
    {
        $this->thumbnails[] = $thumbnail;
    }

    /**
     * {@inheritDoc}
     * @see \IIIF\PresentationAPI\Resources\ResourceInterface::getThumbnails()
     * @return array
     */
    public function getThumbnails()
    {
        return $this->thumbnails;
    }

    /**
     * {@inheritDoc}
     *
     * @todo Remove since this it now allowed on resources
     */
    public function addLogo(Logo $logo): void
    {
        $this->logos[] = $logo;
    }

    /**
     * {@inheritDoc}
     * @see \IIIF\PresentationAPI\Resources\ResourceInterface::getLogos()
     * @return array
     *
     * @todo Remove since this it now allowed on resources
     */
    public function getLogos()
    {
        return $this->logos;
    }

    /**
     * Set the metadata.
     */
    public function setMetadata(Metadata $metadata): void
    {
        $this->metadata = $metadata;
    }

    /**
     * Get the metadata.
     * @return array
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * {@inheritDoc}
     */
    public function addSeeAlso(SeeAlso $seeAlso): void
    {
        $this->seeAlso[] = $seeAlso;
    }

    /**
     * {@inheritDoc}
     */
    public function getSeeAlso(): array
    {
        return $this->seeAlso;
    }

    /**
     * Set the navDate.
     * @param DateTimeInterface $navdate
     */
    public function setNavDate(DateTimeInterface $navdate): void
    {
        $this->navdate = $navdate->format('Y-m-d\T:H:i:s\Z');
    }

    /**
     * Get the navDate.
     */
    public function getNavDate()
    {
        return $this->navdate;
    }

    /**
     * Create an array from the class elements.
     * {@inheritDoc}
     * @see \IIIF\PresentationAPI\Resources\ResourceInterface::toArray()
     */
    abstract public function toArray();
}
