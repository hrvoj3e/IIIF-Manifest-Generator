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
 * Annotation resource.
 * @link https://iiif.io/api/presentation/3.0/#56-annotation
 */
class Annotation extends AnnotationAbstract
{
    /**
     * Type.
     */
    protected const TYPE = 'Annotation';

    /**
     * Motivation.
     */
    protected ?string $motivation = null;

    /**
     * Target.
     */
    protected ?string $target = null;

    /**
     * Body.
     */
    protected ?ContentResource $body = null;

    /**
     * Set the motivation.
     */
    public function setMotivation(string $motivation): void
    {
        $this->motivation = $motivation;
    }

    /**
     * Get the motivation.
     */
    public function getMotivation(): string
    {
        return $this->motivation;
    }

    /**
     * Set the target.
     */
    public function setTarget(string $target): void
    {
        $this->target = $target;
    }

    /**
     * Get the target.
     */
    public function getTarget(): string
    {
        return $this->target;
    }

    /**
     * Set the content resource.
     */
    public function setBody(ContentResource $contentResource): void
    {
        $this->body = $contentResource;
    }

    /**
     * Get the content resource.
     */
    public function getBody(): ?ContentResource
    {
        return $this->body;
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        $array = [];

        ArrayCreator::addRequired($array, Identifier::MOTIVATION, $this->motivation, 'The motivation must be present in an Annotation');
        ArrayCreator::addRequired($array, Identifier::TARGET, $this->target, 'The target must be present in an Annotation');

        // Resource Types

        if (!empty($this->body)) {
            ArrayCreator::add($array, Identifier::BODY, $this->body);
        }

        return [...parent::toArray(), ...$array];
    }
}
