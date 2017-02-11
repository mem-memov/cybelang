<?php

namespace MemMemov\GraphStore\NodeStore;

use MemMemov\SpaceGraph\Store as SpaceGraphStore;

class Store implements SpaceGraphStore
{
    private $nodeStore;
    private $valueStore;

    public function __construct(
        NodeStore $nodeStore,
        ValueStore $valueStore
    ) {
        $this->nodeStore = $nodeStore;
        $this->valueStore = $valueStore;
    }
}