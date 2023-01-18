<?php

declare(strict_types=1);

namespace IIIF\PresentationAPI\Properties\Technical;

/**
 * Allowed behaviors.
 */
enum Behaviors: string
{
    case AUTO_ADVANCE    = 'auto-advance';
    case CONTINUOUS      = 'continuous';
    case FACING_PAGES    = 'facing-pages';
    case HIDDEN          = 'hidden';
    case INDIVIDUALS     = 'individuals';
    case MULTI_PART      = 'multi-part';
    case NO_AUTO_ADVANCE = 'no-auto-advance';
    case NO_NAV          = 'no-nav';
    case NO_REPEAT       = 'no-repeat';
    case NON_PAGED       = 'non-paged';
    case PAGED           = 'paged';
    case REPEAT          = 'repeat';
    case SEQUENCE        = 'sequence';
    case THUMBNAIL       = 'thumbnail-nav';
    case TOGETHER        = 'together';
    case UNORDERED       = 'unordered';
}
