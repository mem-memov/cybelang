<?php

namespace MemMemov\Cybelang\SpaceGraph;

use MemMemov\Cybelang\Cybe\Graph;
use MemMemov\Cybelang\Cybe\GraphNode;

class SpaceGraph implements Graph
{
    private $spaceNodes;

    public function __construct(
        SpaceNodesInGraph $spaceNodes
    ) {
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

    public function getNodeValue(int $id): string
    {
        return $this->spaceNodes->valueOfNode($id);
    }

    public function readNode(int $id): GraphNode
    {
        return $this->spaceNodes->readNode($id);
    }

    public function provideSequenceNode(string $type, array $ids): GraphNode
    {
        return $this->spaceNodes->provideSequenceNode($type, $ids);
    }

    /**
     * @return GraphNode[]
     */
    public function readSequenceNodes(string $type, int $id): array
    {
        return $this->spaceNodes->readNodeSequence($type, $id);
    }
    
    public function addNodeToRow(int $id, int $newId): void
    {
        $this->spaceNodes->addNodeToRow($id, $newId);
    }
    
    /**
     * @return GraphNode[]
     */
    public function readRow(string $type, int $id, int $limit): array
    {
        $this->spaceNodes->readRow($type, $id, $limit);
    }
}