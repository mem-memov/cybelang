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

    public function createNode(Nodes $nodes): SpaceNode
    {
        $node = $nodes->create();
        $node->add($this->node);

        return new SpaceNode($node, $this);
    }

    public function readNode(int $id, Nodes $nodes): SpaceNode
    {
        $node = $nodes->read($id);

        if (!$node->has($this->node)) {
            throw new \Exception(sprintf('Space %s(%d) has no node %d.', $this->name, $this->node->id(), $id));
        }

        return new SpaceNode($node, $this);
    }

    public function has(Node $node): bool
    {
        return $node->has($this->node);
    }

    public function add(Node $node): void
    {
        $node->addNode($this->node);
    }

    public function filter(Node $node): array
    {
        $selectedNodes = [];
        foreach ($node->all() as $connectedNode) {
            if ($connectedNode->has($this->node)) {
                $selectedNodes[] = $connectedNode;
            }
        }

        return $selectedNodes;
    }
}