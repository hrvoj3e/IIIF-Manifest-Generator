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
 * Abstract implementation of linking properties.
 * @link https://iiif.io/api/presentation/3.0/#33-linking-properties
 */
abstract class LinkAbstract implements LinkInterface
{
    protected string $id;
    protected string|null $type = null;
    protected string $profile; // @todo Move out to SeeAlso or to a trait for more classes need it
    protected string $format;
    protected LanguageStrings|null $label = null;
    protected array $language = [];

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
     *
     * @todo Move out to SeeAlso or to a trait for more classes need it
     */
    public function setProfile(string $profile): void
    {
        $this->profile = $profile;
    }

    /**
     * {@inheritDoc}
     *
     * @todo Move out to SeeAlso or to a trait for more classes need it
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
     * Set the language.
     *
     * @param string[] $language
     */
    public function setLanguage(array $language): void
    {
        $this->language = $language;
    }

    /**
     * Get the language.
     *
     * @return string[]
     */
    public function getLanguage(): array
    {
        return $this->language;
    }

    /**
     * {@inheritDoc}
     */
    abstract public function toArray(): array;
}
