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
 *  @package  Parameters
 *  @author   Harry Shyket <harry.shyket@yale.edu>
 *  @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
*/

namespace IIIF\PresentationAPI\Parameters;

/**
 * Values used throughout the specification documentation.
 */
class Identifier
{
    public const ATTRIBUTION      = 'attribution';
    public const ATVALUE          = '@value';
    public const CANVASES         = 'canvases';
    public const COLLECTIONS      = 'collections';
    public const CONTENTLAYER     = 'contentLayer';
    public const CONTEXT          = '@context';
    public const DESCRIPTION      = 'description';
    public const FORMAT           = 'format';
    public const FORMATS          = 'formats';
    public const HEIGHT           = 'height';
    public const ID               = 'id';
    public const IMAGES           = 'images';
    public const LABEL            = 'label';
    public const CHARS            = 'chars';
    public const LANG             = '@lang';
    public const LANGUAGE         = '@language';
    public const LICENSE          = 'license';
    public const LOGO             = 'logo';
    public const MANIFESTS        = 'manifests';
    public const MAXAREA          = 'maxArea';
    public const MAXHEIGHT        = 'maxHeight';
    public const MAXWIDTH         = 'maxWidth';
    public const MEMBERS          = 'members';
    public const METADATA         = 'metadata';
    public const MOTIVATION       = 'motivation';
    public const NAVDATE          = 'navDate';
    public const ON               = 'on';
    public const OTHERCONTENT     = 'otherContent';
    public const PROFILE          = 'profile';
    public const PROTOCOL         = 'protocol';
    public const QUALITIES        = 'qualities';
    public const RANGES           = 'ranges';
    public const RELATED          = 'related';
    public const RENDERING        = 'rendering';
    public const RESOURCE         = 'resource';
    public const RESOURCES        = 'resources';
    public const SCALEFACTORS     = 'scaleFactors';
    public const SEEALSO          = 'seeAlso';
    public const SEQUENCES        = 'sequences';
    public const SERVICE          = 'service';
    public const SIZES            = 'sizes';
    public const STARTCANVAS      = 'startCanvas';
    public const STRUCTURES       = 'structures';
    public const SUPPORTS         = 'supports';
    public const THUMBNAIL        = 'thumbnail';
    public const TILES            = 'tiles';
    public const TOTAL            = 'total';
    public const TYPE             = 'type';
    public const VALUE            = 'value';
    public const VIEWINGDIRECTION = 'viewingDirection';
    public const VIEWINGHINT      = 'viewingHint';
    public const WIDTH            = 'width';
    public const WITHIN           = 'within';
}
