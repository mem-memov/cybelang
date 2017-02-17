<?php

namespace MemMemov\Cybe;

class ClauseArguments
{
    private $graphNodes;

    public function __construct(
        array $graphNodes
    ) {
        $this->graphNodes = array_map(function (GraphNode $graphNode) {
            return $graphNode;
        }, $graphNodes);
    }
}