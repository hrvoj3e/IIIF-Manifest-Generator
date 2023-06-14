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
 * @package  Parameters
 * @author   Harry Shyket <harry.shyket@yale.edu>
 * @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 */

namespace IIIF\PresentationAPI\Parameters;

/**
 * Values used throughout the specification documentation.
 */
enum Identifier: string
{
    case ANNOTATIONS        = 'annotations';
    case ATVALUE            = '@value';
    case BEHAVIOR           = 'behavior';
    case BODY               = 'body';
    case CANVASES           = 'canvases';
    case CHARS              = 'chars';
    case COLLECTIONS        = 'collections';
    case CONTENT_LAYER      = 'contentLayer';
    case CONTEXT            = '@context';
    case DURATION           = 'duration';
    case FORMAT             = 'format';
    case FORMATS            = 'formats';
    case HEIGHT             = 'height';
    case HOMEPAGE           = 'homepage';
    case ID                 = 'id';
    case IMAGES             = 'images';
    case ITEMS              = 'items';
    case LABEL              = 'label';
    case LANGUAGE           = 'language';
    case LOGO               = 'logo';
    case MANIFESTS          = 'manifests';
    case MAX_AREA           = 'maxArea';
    case MAX_HEIGHT         = 'maxHeight';
    case MAX_WIDTH          = 'maxWidth';
    case MEMBERS            = 'members';
    case METADATA           = 'metadata';
    case MOTIVATION         = 'motivation';
    case NAVDATE            = 'navDate';
    case ON                 = 'on';
    case OTHER_CONTENT      = 'otherContent';
    case PART_OF            = 'partOf';
    case PROFILE            = 'profile';
    case PROTOCOL           = 'protocol';
    case PROVIDER           = 'provider';
    case QUALITIES          = 'qualities';
    case RANGES             = 'ranges';
    case RENDERING          = 'rendering';
    case REQUIRED_STATEMENT = 'requiredStatement';
    case RESOURCES          = 'resources';
    case RIGHTS             = 'rights';
    case ROTATION           = 'rotation';
    case SCALE_FACTORS      = 'scaleFactors';
    case SEE_ALSO           = 'seeAlso';
    case SEQUENCES          = 'sequences';
    case SERVICE            = 'service';
    case SERVICES           = 'services';
    case SIZES              = 'sizes';
    case START              = 'start';
    case STRUCTURES         = 'structures';
    case SUMMARY            = 'summary';
    case SUPPORTS           = 'supports';
    case TARGET             = 'target';
    case THUMBNAIL          = 'thumbnail';
    case TILES              = 'tiles';
    case TOTAL              = 'total';
    case TYPE               = 'type';
    case VALUE              = 'value';
    case VIEWING_DIRECTION  = 'viewingDirection';
    case WIDTH              = 'width';
}
