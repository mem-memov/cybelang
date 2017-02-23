<?php

namespace MemMemov\SpaceGraph;

class Space
{
    private $name;
    private $node;
    private $nodes;

    public function __construct(
        string $name,
        Node $node,
        Nodes $nodes
    ) {
        $this->name = $name;
        $this->node = $node;
        $this->nodes = $nodes;
    }

    public function id(): int
    {
        return $this->node->id();
    }

    /**
     * @param Node[] $nodes
     * @return SpaceNode
     */
    public function createCommonNode(array $nodes): SpaceNode
    {
        $node = $this->nodes->createCommonNode($nodes);
        $node->add($this->node);

        return new SpaceNode($node, $this);
    }

    public function createNodeForValue(string $value): SpaceNode
    {
        $node = $this->nodes->nodeForValue($value);

        if (!$node->has($this->node)) {
            $node->add($this->node);
        }

        return new SpaceNode($node, $this);
    }

    public function getOneNode(Node $node): SpaceNode
    {
        $selectedNodes = $this->nodes->filter($this->node, $node->all());

        if (1 !== count($selectedNodes)) {
            throw new RequireOneNode(sprintf('%d nodes of type %s found in node %d instead of one', count($selectedNodes), $this->name, $node->id()));
        }

        return new SpaceNode($selectedNodes[0], $this);
    }

    /**
     * @param Node $node
     * @return SpaceNode[]
     */
    public function findNodes(Node $node): array
    {
        $selectedNodes = $this->nodes->filter($this->node, $node->all());

        $spaceNodes = [];
        foreach ($selectedNodes as $selectedNode) {
            $spaceNodes[] = new SpaceNode($selectedNode, $this->spaces);
        }

        return $spaceNodes;
    }

    public function readNode(int $id): SpaceNode
    {
        $node = $this->nodes->read($id);

        if (!$node->has($this->node)) {
            throw new NodeNotFoundInSpace(sprintf('Space %s(%d) has no node %d.', $this->name, $this->node->id(), $id));
        }

        return new SpaceNode($node, $this);
    }

    public function has(Node $node): bool
    {
        return $node->has($this->node);
    }
}