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
 *  @category IIIF\PresentationAPI
 *  @package  Resources
 *  @author   Harry Shyket <harry.shyket@yale.edu>
 *  @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 *
*/

namespace IIIF\PresentationAPI\Resources;

use DateTimeInterface;
use IIIF\PresentationAPI\Links\Related;
use IIIF\PresentationAPI\Links\Rendering;
use IIIF\PresentationAPI\Links\Service;
use IIIF\PresentationAPI\Metadata\Metadata;
use IIIF\PresentationAPI\Parameters\Identifier;
use IIIF\PresentationAPI\Properties\Logo;
use IIIF\PresentationAPI\Properties\Thumbnail;
use IIIF\Utils\Validator;

/**
 * Abstract implementation of a resource.
 */
abstract class ResourceAbstract implements ResourceInterface
{
    protected $id;
    protected $onlyid         = false;
    protected $istoplevel     = false;
    protected $onlymemberdata = false;

    protected $type;
    protected $defaultcontext = 'http://iiif.io/api/presentation/3/context.json';
    protected $viewingdirection;
    protected $navdate;

    protected $contexts       = [];
    protected $labels         = [];
    protected $viewinghints   = [];
    protected $descriptions   = [];
    protected $attributions   = [];
    protected $licenses       = [];
    protected $thumbnails     = [];
    protected $logos          = [];
    protected $metadata       = [];
    protected $seealso        = [];
    protected $services       = [];
    protected $related        = [];
    protected $rendering      = [];
    protected $within         = [];

    /**
     * Sets whether the item is a top level item.
     * @param bool $top
     */
    public function __construct($top = false)
    {
        $this->istoplevel = (bool) $top;

        if ($this->istoplevel) {
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
     * @return bool;
     */
    public function isTopLevel()
    {
        return $this->istoplevel;
    }

    /**
     * {@inheritDoc}
     * @see \IIIF\PresentationAPI\Resources\ResourceInterface::addContext()
     * @param string
     */
    public function addContext($context): void
    {
        array_push($this->contexts, $context);
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
     * @see \IIIF\PresentationAPI\Resources\ResourceInterface::addLabel()
     * @param array|string $label
     * @param string       $language
     */
    public function addLabel(array|string $label, string $language): void
    {
        array_push($this->labels, [$language => (array) $label]);
    }

    /**
     * {@inheritDoc}
     * @see \IIIF\PresentationAPI\Resources\ResourceInterface::getLabelss()
     * @return array
     */
    public function getLabels()
    {
        return $this->labels;
    }

    /**
     * {@inheritDoc}
     * @see \IIIF\PresentationAPI\Resources\ResourceInterface::addViewingHints()
     * @param string
     */
    public function addViewingHint($viewinghint): void
    {
        // Make sure that the viewing hint is an allowed value
        $allviewinghints = new \ReflectionClass('\IIIF\PresentationAPI\Parameters\ViewingHint');
        if (Validator::inArray($viewinghint, $allviewinghints->getConstants(), 'Illegal viewingHint selected')) {
            array_push($this->viewinghints, $viewinghint);
        }
    }

    /**
     * {@inheritDoc}
     * @see \IIIF\PresentationAPI\Resources\ResourceInterface::getViewingHints()
     * @return array
     */
    public function getViewingHints()
    {
        return $this->viewinghints;
    }

    /**
     * {@inheritDoc}
     * @see \IIIF\PresentationAPI\Resources\ResourceInterface::addDescription()
     * @param string
     * @param string
     */
    public function addDescription($description, $language = null): void
    {
        if (!empty($language)) {
            $description = [Identifier::ATVALUE => $description, Identifier::LANGUAGE => $language];
        }

        array_push($this->descriptions, $description);
    }

    /**
     * {@inheritDoc}
     * @see \IIIF\PresentationAPI\Resources\ResourceInterface::getDescriptions()
     * @return string
     */
    public function getDescriptions()
    {
        return $this->descriptions;
    }

    /**
     * {@inheritDoc}
     * @see \IIIF\PresentationAPI\Resources\ResourceInterface::addAttribution()
     * @param string
     * @param string
     */
    public function addAttribution($attribution, $language = null): void
    {
        if (!empty($language)) {
            $attribution = [Identifier::ATVALUE => $attribution, Identifier::LANGUAGE => $language];
        }

        array_push($this->attributions, $attribution);
    }

    /**
     * {@inheritDoc}
     * @see \IIIF\PresentationAPI\Resources\ResourceInterface::getAttributions()
     * @return array
     */
    public function getAttributions()
    {
        return $this->attributions;
    }

    /**
     * {@inheritDoc}
     * @see \IIIF\PresentationAPI\Resources\ResourceInterface::addLicense()
     * @param string
     */
    public function addLicense($license): void
    {
        // Make sure it is a valid URL
        if (Validator::validateURL($license, 'The license must be a valid URL')) {
            array_push($this->licenses, $license);
        }
    }

    /**
     * {@inheritDoc}
     * @see \IIIF\PresentationAPI\Resources\ResourceInterface::getLicenses()
     * @return array
     */
    public function getLicenses()
    {
        return $this->licenses;
    }

    /**
     * {@inheritDoc}
     * @see \IIIF\PresentationAPI\Resources\ResourceInterface::addThumbnail()
     * @param \IIIF\PresentationAPI\Properties\Thumbnail
     */
    public function addThumbnail(Thumbnail $thumbnail): void
    {
        array_push($this->thumbnails, $thumbnail);
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
     * @see \IIIF\PresentationAPI\Resources\ResourceInterface::addLogo()
     * @param \IIIF\PresentationAPI\Properties\Logo
     */
    public function addLogo(Logo $logo): void
    {
        array_push($this->logos, $logo);
    }

    /**
     * {@inheritDoc}
     * @see \IIIF\PresentationAPI\Resources\ResourceInterface::getLogos()
     * @return array
     */
    public function getLogos()
    {
        return $this->logos;
    }

    /**
     * Set the metadata.
     * @param \IIIF\PresentationAPI\Metadata\Metadata $metadata
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
     * @see \IIIF\PresentationAPI\Resources\ResourceInterface::addSeeAlso()
     * @param \IIIF\PresentationAPI\Links\SeeAlso $seealso
     */
    public function addSeeAlso($seealso): void
    {
        array_push($this->seealso, $seealso);
    }

    /**
     * {@inheritDoc}
     * @see \IIIF\PresentationAPI\Resources\ResourceInterface::getAttributions()
     * @return array
     */
    public function getSeeAlso()
    {
        return $this->seealso;
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
     * {@inheritDoc}
     * @see \IIIF\PresentationAPI\Resources\ResourceInterface::addService()
     * @param \IIIF\PresentationAPI\Links\Service
     */
    public function addService(Service $service): void
    {
        array_push($this->services, $service);
    }

    /**
     * {@inheritDoc}
     * @see \IIIF\PresentationAPI\Resources\ResourceInterface::getAttributions()
     * @return array
     */
    public function getServices()
    {
        return $this->services;
    }

    /**
     * {@inheritDoc}
     * @see \IIIF\PresentationAPI\Resources\ResourceInterface::addRelated()
     */
    public function addRelated(Related $related): void
    {
        array_push($this->related, $related);
    }

    /**
     * {@inheritDoc}
     * @see \IIIF\PresentationAPI\Resources\ResourceInterface::getRelated()
     */
    public function getRelated()
    {
        return $this->related;
    }

    /**
     * {@inheritDoc}
     * @see \IIIF\PresentationAPI\Resources\ResourceInterface::addRendering()
     */
    public function addRendering(Rendering $rendering): void
    {
        array_push($this->rendering, $rendering);
    }

    /**
     * {@inheritDoc}
     * @see \IIIF\PresentationAPI\Resources\ResourceInterface::getRendering()
     */
    public function getRendering()
    {
        return $this->rendering;
    }

    /**
     * {@inheritDoc}
     * @see \IIIF\PresentationAPI\Resources\ResourceInterface::addWithin()
     */
    public function addWithin($within): void
    {
        array_push($this->within, $within);
    }

    /**
     * {@inheritDoc}
     * @see \IIIF\PresentationAPI\Resources\ResourceInterface::getWithin()
     */
    public function getWithin()
    {
        return $this->within;
    }

    /**
     * Set the viewing direction.
     *
     * @param string $viewingdirection
     */
    public function setViewingDirection($viewingdirection): void
    {
        // Make sure that the viewing hint is an allowed value
        $allviewingdirections = new \ReflectionClass('\IIIF\PresentationAPI\Parameters\ViewingDirection');
        if (Validator::inArray($viewingdirection, $allviewingdirections->getConstants(), 'Illegal viewingDirection selected')) {
            $this->viewingdirection =  $viewingdirection;
        }
    }

    /**
     * Get the viewng direction.
     *
     * @return string
     */
    public function getViewingDirection()
    {
        return $this->viewingdirection;
    }

    /**
     * Create an array from the class elements.
     * {@inheritDoc}
     * @see \IIIF\PresentationAPI\Resources\ResourceInterface::toArray()
     */
    abstract public function toArray();
}
