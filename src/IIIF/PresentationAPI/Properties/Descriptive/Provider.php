<?php

declare(strict_types=1);

namespace IIIF\PresentationAPI\Properties\Descriptive;

use IIIF\PresentationAPI\ArrayableInterface;

class Provider implements ArrayableInterface
{
    protected array $agents = [];

    /**
     * Constructor.
     */
    public function __construct(Agent ...$agent)
    {
        $this->agents = $agent;
    }

    /**
     * Add an agent.
     */
    public function addAgent(Agent $agent): void
    {
        $this->agents[] = $agent;
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        $array = [];

        foreach ($this->agents as $agent) {
            $array[] = $agent->toArray();
        }

        return $array;
    }
}
