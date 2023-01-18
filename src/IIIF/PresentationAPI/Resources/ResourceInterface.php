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
use IIIF\PresentationAPI\Links\Related;
use IIIF\PresentationAPI\Links\Rendering;
use IIIF\PresentationAPI\Links\SeeAlso;
use IIIF\PresentationAPI\Links\Service;
use IIIF\PresentationAPI\Metadata\Metadata;
use IIIF\PresentationAPI\Properties\Descriptive\Thumbnail;
use IIIF\PresentationAPI\Properties\Linking\Logo;
use IIIF\PresentationAPI\Properties\Technical\Behavior;

/**
 * Interface for resources.
 */
interface ResourceInterface
{
    /**
     * Check if the item is a top level item. This is needed to validate
     * that the context is set for the top level item.
     * @param bool $top
     */
    public function isTopLevel();

    /**
     * Add an item to the context.
     */
    public function addContext($context);

    /**
     * Get the context.
     */
    public function getContexts();

    /**
     * Get the default context.
     */
    public function getDefaultContext();

    /**
     * Set the ID.
     */
    public function setID($id);

    /**
     * Get the ID.
     */
    public function getID();

    /**
     * Get the resource type.
     */
    public function getType();

    /**
     * Sets the label.
     */
    public function setLabel(LanguageStrings $languageStrings): void;

    /**
     * Get the label.
     */
    public function getLabel();

    /**
     * Set the behavior.
     */
    public function setBehavior(Behavior $behavior): void;

    /**
     * Get the behavior.
     */
    public function getBehavior(): Behavior;

    /**
     * Set the summary.
     *
     * @param \IIIF\PresentationAPI\LanguageStrings $languageStrings
     */
    public function setSummary(LanguageStrings $languageStrings): void;

    /**
     * Get the summary.
     */
    public function getSummary(): LanguageStrings;

    /**
     * Add an attribution.
     */
    public function setRequiredStatement(LabelValueItem $labelValueItem): void;

    /**
     * Get the attribution.
     */
    public function getRequiredStatement(): ?LabelValueItem;

    /**
     * Add the rights.
     */
    public function setRights(string $rights): void;

    /**
     * Get the rights.
     */
    public function getRights(): ?string;

    /**
     * Add a thumbnail.
     */
    public function addThumbnail(Thumbnail $thumbnail);

    /**
     * Get the thumbnails.
     */
    public function getThumbnails();

    /**
     * Add a logo.
     */
    public function addLogo(Logo $logo);

    /**
     * Get the logos.
     */
    public function getLogos();

    /**
     * Set the metadata.
     */
    public function setMetadata(Metadata $metadata);

    /**
     * Get the metadata.
     */
    public function getMetadata();

    /**
     * Add to seeAlso.
     */
    public function addSeeAlso(SeeAlso $seealso): void;

    /**
     * Get the seeAlso.
     *
     * @return SeeAlso[]
     */
    public function getSeeAlso(): array;

    /**
     * Set the navDate.
     */
    public function setNavDate(DateTimeInterface $navdate): void;

    /**
     * Get the navDate.
     */
    public function getNavDate();

    /**
     * Add a service.
     */
    public function addService(Service $service);

    /**
     * Get the services.
     */
    public function getServices();

    /**
     * Add a related item.
     */
    public function addRelated(Related $related);

    /**
     * Get the related items.
     */
    public function getRelated();

    /**
     * Add a rendering item.
     */
    public function addRendering(Rendering $rendering);

    /**
     * Get the rendering items.
     */
    public function getRendering();

    /**
     * Add a within item.
     * Pass a Layer object if part of Layer.
     */
    public function addWithin($within);

    /**
     * Get the within items.
     */
    public function getWithin();

    /**
     * Convert objects inside the classes to arrays for the manifest.
     */
    public function toArray();
}
