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
    case REQUIRED_STATEMENT = 'requiredStatement';
    case ATVALUE            = '@value';
    case CANVASES           = 'canvases';
    case COLLECTIONS        = 'collections';
    case CONTENTLAYER       = 'contentLayer';
    case CONTEXT            = '@context';
    case SUMMARY            = 'summary';
    case FORMAT             = 'format';
    case FORMATS            = 'formats';
    case HEIGHT             = 'height';
    case ID                 = 'id';
    case IMAGES             = 'images';
    case LABEL              = 'label';
    case CHARS              = 'chars';
    case LANG               = '@lang';
    case LANGUAGE           = '@language';
    case RIGHTS             = 'rights';
    case LOGO               = 'logo';
    case MANIFESTS          = 'manifests';
    case MAXAREA            = 'maxArea';
    case MAXHEIGHT          = 'maxHeight';
    case MAXWIDTH           = 'maxWidth';
    case MEMBERS            = 'members';
    case METADATA           = 'metadata';
    case MOTIVATION         = 'motivation';
    case NAVDATE            = 'navDate';
    case ON                 = 'on';
    case OTHERCONTENT       = 'otherContent';
    case PROFILE            = 'profile';
    case PROTOCOL           = 'protocol';
    case QUALITIES          = 'qualities';
    case RANGES             = 'ranges';
    case RELATED            = 'related';
    case RENDERING          = 'rendering';
    case RESOURCE           = 'resource';
    case RESOURCES          = 'resources';
    case SCALEFACTORS       = 'scaleFactors';
    case SEEALSO            = 'seeAlso';
    case SEQUENCES          = 'sequences';
    case SERVICE            = 'service';
    case SIZES              = 'sizes';
    case STARTCANVAS        = 'startCanvas';
    case STRUCTURES         = 'structures';
    case SUPPORTS           = 'supports';
    case THUMBNAIL          = 'thumbnail';
    case TILES              = 'tiles';
    case TOTAL              = 'total';
    case TYPE               = 'type';
    case VALUE              = 'value';
    case VIEWINGDIRECTION   = 'viewingDirection';
    case VIEWINGHINT        = 'viewingHint';
    case WIDTH              = 'width';
    case WITHIN             = 'within';
}
