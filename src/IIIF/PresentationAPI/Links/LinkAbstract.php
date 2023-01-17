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
 * @package  Links
 * @author   Harry Shyket <harry.shyket@yale.edu>
 * @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 */

namespace IIIF\PresentationAPI\Links;

use IIIF\PresentationAPI\LanguageStrings;

/**
 * Abstract implementation of Link properties.
 */
abstract class LinkAbstract implements LinkInterface
{
    protected string $id;
    protected string $type;
    protected string $profile;
    protected string $format;
    protected LanguageStrings|null $label = null;

    /**
     * {@inheritDoc}
     */
    public function setID(string $id): void
    {
        $this->id = $id;
    }

    /**
     * {@inheritDoc}
     */
    public function getID(): string
    {
        return $this->id;
    }

    /**
     * {@inheritDoc}
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getType(): string
    {
        return $this->type;
    }

    /**
     * {@inheritDoc}
     *
     * @todo Move out to SeeAlso or to a trait for more classes need it
     */
    public function setFormat($format): void
    {
        $this->format = $format;
    }

    /**
     * {@inheritDoc}
     *
     * @todo Move out to SeeAlso or to a trait for more classes need it
     */
    public function getFormat(): string
    {
        return $this->format;
    }

    /**
     * {@inheritDoc}
     */
    public function setProfile(string $profile): void
    {
        $this->profile = $profile;
    }

    /**
     * {@inheritDoc}
     */
    public function getProfile(): string
    {
        return $this->profile;
    }

    /**
     * {@inheritDoc}
     *
     * @todo Move out to SeeAlso or to a trait for more classes need it
     */
    public function setLabel(LanguageStrings $label): void
    {
        $this->label = $label;
    }

    /**
     * {@inheritDoc}
     *
     * @todo Move out to SeeAlso or to a trait for more classes need it
     */
    public function getLabel(): ?LanguageStrings
    {
        return $this->label;
    }

    /**
     * {@inheritDoc}
     */
    abstract public function toArray(): array;
}
