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

use IIIF\PresentationAPI\Parameters\Identifier;
use IIIF\Utils\ArrayCreator;

/**
 * Implementation of an Annotation resource.
 * @link https://iiif.io/api/presentation/3.0/#56-annotation
 */
class Annotation extends ResourceAbstract
{
    private $content;
    private $on;

    public $type = 'oa:Annotation';
    public $motivation = 'sc:painting';

    /**
     * Set the motivation.
     *
     * @param string $motivation
     */
    public function setMotivation($motivation): void
    {
        $this->motivation = $motivation;
    }

    /**
     * Get the motivation.
     *
     * @return string
     */
    public function getMotivation()
    {
        return $this->motivation;
    }

    /**
     * Set the content resource.
     *
     * @param \IIIF\PresentationAPI\Resources\Content $content
     */
    public function setContent(Content $content): void
    {
        $this->content = $content;
    }

    /**
     * Get the content resource.
     *
     * @return \IIIF\PresentationAPI\Resources\Content
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set the on value.
     *
     * @param string $on
     */
    public function setOn($on): void
    {
        $this->on = $on;
    }

    /**
     * Get the on value.
     *
     * @return string
     */
    public function getOn()
    {
        return $this->on;
    }

    /**
     * {@inheritDoc}
     * @see \IIIF\PresentationAPI\Resources\ResourceAbstract::toArray()
     * @return array
     */
    public function toArray()
    {
        $array = [];

        /* Technical Properties **/
        if ($this->isTopLevel()) {
            ArrayCreator::addRequired($array, Identifier::CONTEXT, $this->getContexts(), 'The context must be present in the Annotation');
        }
        ArrayCreator::addIfExists($array, Identifier::ID, $this->getID());
        ArrayCreator::addRequired($array, Identifier::TYPE, $this->getType(), 'The type must be present in the Annotation');
        ArrayCreator::addRequired($array, Identifier::MOTIVATION, $this->getMotivation(), 'The motiation must be present in an Annotation');
        ArrayCreator::addIfExists($array, Identifier::VIEWINGHINT, $this->getViewingHints());
        ArrayCreator::addRequired($array, Identifier::ON, $this->getOn(), 'The on value must be present in an Annotation');

        /* Descriptive Properties **/

        if (!empty($this->label)) {
            ArrayCreator::add($array, Identifier::LABEL, $this->label, true);
        }

        ArrayCreator::addIfExists($array, Identifier::METADATA, $this->getMetadata());

        if (!empty($this->summary)) {
            ArrayCreator::add($array, Identifier::SUMMARY, $this->summary);
        }

        ArrayCreator::addIfExists($array, Identifier::THUMBNAIL, $this->getThumbnails());

        /* Rights and Licensing Properties **/

        if (!empty($this->requiredStatement)) {
            ArrayCreator::add($array, Identifier::REQUIRED_STATEMENT, $this->requiredStatement);
        }

        if (!empty($this->rights)) {
            ArrayCreator::add($array, Identifier::RIGHTS, $this->rights);
        }

        ArrayCreator::addIfExists($array, Identifier::LOGO, $this->getLogos());

        /* Linking Properties **/
        ArrayCreator::addIfExists($array, Identifier::RELATED, $this->getRelated());
        ArrayCreator::addIfExists($array, Identifier::RENDERING, $this->getRendering());
        ArrayCreator::addIfExists($array, Identifier::SERVICE, $this->getServices());
        ArrayCreator::addIfExists($array, Identifier::SEEALSO, $this->getSeeAlso());
        ArrayCreator::addIfExists($array, Identifier::WITHIN, $this->getWithin());

        /* Resource Types **/
        ArrayCreator::addIfExists($array, Identifier::RESOURCE, $this->getContent());

        return $array;
    }
}
