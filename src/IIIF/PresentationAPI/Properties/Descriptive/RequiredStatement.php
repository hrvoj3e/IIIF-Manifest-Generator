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

use IIIF\PresentationAPI\LabelValueItem;
use IIIF\PresentationAPI\LanguageStrings;

/**
 * Required statement descriptive property.
 * @link https://iiif.io/api/presentation/3.0/#provider
 */
class RequiredStatement extends LabelValueItem
{
    /**
     * @var LabelValueItem[]
     */
    protected array $additionalInformation = [];

    protected null|bool $isRestricted = null;

    /**
     * Constructor.
     */
    public function __construct(
        LanguageStrings $label,
        LanguageStrings $value
    ) {
        parent::__construct($label, $value);
    }

    /**
     * Add additional information.
     */
    public function addAdditionalInformation(LabelValueItem $additionalInformation): void
    {
        $this->additionalInformation[] = $additionalInformation;
    }

    /**
     * Sets the isRestricted property.
     */
    public function setIsRestricted(bool $isRestricted): void
    {
        $this->isRestricted = $isRestricted;
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        $array = parent::toArray();

        if(!empty($this->additionalInformation)) {
            $array['additionalInformation'] = array_map(fn ($item) => $item->toArray(), $this->additionalInformation);
        }

        if($this->isRestricted !== null) {
            $array['isRestricted'] = $this->isRestricted;
        }

        return $array;
    }
}
