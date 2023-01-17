<?php

namespace IIIF\PresentationAPI\Properties\Technical;

class Behavior
{
    protected array $behaviors = [];

    public function toArray(): array
    {
        $behaviors = [];

        foreach ($this->behaviors as $behavior) {
            $behaviors[] = $behavior->value;
        }

        return $behavior;
    }
}
