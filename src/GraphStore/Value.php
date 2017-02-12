<?php

namespace MemMemov\GraphStore;

use MemMemov\SpaceGraph\Node as SpaceGraphNode;
use MemMemov\SpaceGraph\Value as SpaceGraphValue;

class Value implements SpaceGraphValue
{
    private $valueKey;
    private $nodeId;

    public function __construct(
        $valueKey,
        $nodeId
    ) {
        $this->valueKey = $valueKey;
        $this->nodeId = $nodeId;
    }

    public function getContents(): string
    {

    }

    public function getNode(): SpaceGraphNode
    {

    }
}