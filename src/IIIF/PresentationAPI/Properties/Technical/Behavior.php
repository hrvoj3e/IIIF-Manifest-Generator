<?php

declare(strict_types=1);

namespace IIIF\PresentationAPI\Properties\Technical;

/**
 * Behavior tenchnical property.
 * @link https://iiif.io/api/presentation/3.0/#behavior
 */
class Behavior
{
    /**
     * @var Behaviors[]
     */
    protected array $behaviors = [];

    /**
     * Constructor.
     */
    public function __construct(Behaviors ...$behaviors)
    {
        $this->behaviors = $behaviors;
    }

    /**
     * Converts to object to an array.
     */
    public function toArray(): array
    {
        $behaviors = [];

        foreach ($this->behaviors as $behavior) {
            $behaviors[] = $behavior->value;
        }

        return $behaviors;
    }
}
