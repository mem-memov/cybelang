<?php

namespace MemMemov\SpaceGraph;

class Space
{
    private $name;
    private $node;

    public function __construct(
        string $name,
        Node $node
    ) {
        $this->name = $name;
        $this->node = $node;
    }

    public function has(Node $node): bool
    {
        foreach ($node->all() as $connectedNode) {
            if ($connectedNode->id() === $this->node->id()) {
                return true;
            }
        }

        return false;
    }

    public function add(Node $node): void
    {
        $node->addNode($this->node);
    }

    public function filter(Node $node): array
    {
        $selectedNodes = [];
        foreach ($node->all() as $connectedNode) {
            foreach ($connectedNode->all() as $aNode) {
                if ($aNode->id() === $this->node->id()) {
                    $selectedNodes[] = $connectedNode;
                }
            }
        }

        return $selectedNodes;
    }
}