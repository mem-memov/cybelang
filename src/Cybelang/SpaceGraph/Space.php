<?php

namespace MemMemov\Cybelang\SpaceGraph;

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

    public function name(): string
    {
        return $this->name;
    }

    /**
     * @param Node[] $nodes
     * @return SpaceNode
     */
    public function createCommonNode(array $nodes): Node
    {
        $node = $this->nodes->createCommonNode($nodes);
        $node->add($this->node);

        return $node;
    }

    public function createNodeForValue(string $value): Node
    {
        $node = $this->nodes->nodeForValue($value);

        if (!$node->has($this->node)) {
            $node->add($this->node);
        }

        return $node;
    }

    public function getOneNode(Node $node): Node
    {
        $selectedNodes = $this->nodes->filter($this->node, $node->all());

        if (1 !== count($selectedNodes)) {
            throw new RequireOneNode(sprintf('%d nodes of type %s found in node %d instead of one', count($selectedNodes), $this->name, $node->id()));
        }

        return $selectedNodes[0];
    }

    /**
     * @param Node $node
     * @return Node[]
     */
    public function findNodes(Node $node): array
    {
        return $this->nodes->filter($this->node, $node->all());
    }

    public function readNode(int $id): Node
    {
        $node = $this->nodes->read($id);

        if (!$node->has($this->node)) {
            throw new NodeNotFoundInSpace(sprintf('Space %s(%d) has no node %d.', $this->name, $this->node->id(), $id));
        }

        return $node;
    }

    public function has(Node $node): bool
    {
        return $node->has($this->node);
    }

    /**
     * @param Node[] $nodes
     * @return Node[]
     */
    public function filter(array $nodes): array
    {
        return array_filter($nodes, function(Node $node) {
            return $node->has($this->node);
        });
    }
}