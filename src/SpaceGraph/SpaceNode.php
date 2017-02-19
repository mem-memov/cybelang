<?php

namespace MemMemov\SpaceGraph;

use MemMemov\Cybe\GraphNode;

class SpaceNode implements GraphNode
{
    private $node;
    private $spaces;

    public function __construct(
        Node $node,
        Spaces $spaces
    ) {
        $this->node = $node;
        $this->spaces = $spaces;
    }

    public function id(): int
    {
        return $this->node->id();
    }

    public function one(string $type): GraphNode
    {
        $space = $this->spaces->provideSpace($type);

        $selectedNodes = $space->filter($this->node);

        if (1 !== count($selectedNodes)) {
            throw new \Exception(sprintf('%d nodes of type %s found in node %d instead of one', count($selectedNodes), $type, $this->node->id()));
        }

        return new SpaceNode($selectedNodes[0], $this->spaces);
    }

    /**
     * @param string $type
     * @return SpaceNode[]
     */
    public function all(string $type): array
    {
        $space = $this->spaces->provideSpace($type);

        $selectedNodes = $space->filter($this->node);

        $spaceNodes = [];

        foreach ($selectedNodes as $selectedNode) {
            $spaceNodes[] = new SpaceNode($selectedNode, $this->spaces);
        }

        return $spaceNodes;
    }
}