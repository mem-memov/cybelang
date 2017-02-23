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

    public function provideSequenceNode(string $type, array $ids): GraphNode
    {
        return $this->spaceNodes->provideSequenceNode($type, $ids);
    }

    /**
     * @param int $id
     * @return GraphNode[]
     */
    public function readSequenceNodes(string $type, int $id): array
    {
        return $this->spaceNodes->readNodeSequence($type, $id);
    }
}