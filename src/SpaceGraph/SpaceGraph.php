<?php

namespace MemMemov\SpaceGraph;

use MemMemov\Cybe\Graph;
use MemMemov\Cybe\GraphNode;
use MemMemov\Cybe\GraphSequence;
use MemMemov\Cybe\GraphValue;

class SpaceGraph implements Graph
{
    private $nodes;
    private $spaces;
    private $spaceNodes;

    public function __construct(
        Nodes $nodes,
        Spaces $spaces,
        SpaceNodes $spaceNodes
    ) {
        $this->nodes = $nodes;
        $this->spaces = $spaces;
        $this->spaceNodes = $spaceNodes;
    }

    public function provideCommonNode(string $type, array $ids): GraphNode
    {
        return $this->spaceNodes->provideCommonNode($type, $ids);
    }

    public function provideValueNode(string $type, string $value): GraphNode
    {
        return $this->spaceNodes->provideNodeForValue($type, $value);
    }

    public function readNode(int $id): GraphNode
    {

    }

    public function сreateSequence(string $type, array $ids): GraphSequence
    {

    }

    public function readSequence(int $id): GraphSequence
    {

    }

    public function сreateValue(string $type, string $content): GraphValue
    {

    }

    public function readValue(int $id): GraphValue
    {

    }
}