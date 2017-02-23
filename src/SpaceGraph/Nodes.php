<?php

namespace MemMemov\SpaceGraph;

class Nodes
{
    private $store;

    public function __construct(
        Store $store
    ) {
        $this->store = $store;
    }

    public function create(): Node
    {
        $id = $this->store->createNode();

        return new Node($id, [], $this->store);
    }

    public function createCommonNode(array $nodes): Node
    {
        $commonNode = $nodes->create();
        foreach ($nodes as $node) {
            $node->add($commonNode);
            $commonNode->add($node);
        }
        return $commonNode;
    }

    public function read(int $id): Node
    {
        $ids = $this->store->readNode($id);

        return new Node($id, $ids, $this->store);
    }

    /**
     * @param int[] $ids
     * @return Node[]
     */
    public function readMany(array $ids): array
    {
        $nodes = [];
        foreach ($ids as $id) {
            $nodes[] = $this->read($id);
        }

        return $nodes;
    }

    public function nodeForValue(string $value): Node
    {
        $id = $this->store->provideNode($value);
        $ids = $this->store->readNode($id);

        return new Node($id, $ids, $this->store);
    }

    public function valueForNode(Node $node): string
    {
        return $this->store->readValue($node->id());
    }

    /**
     * @param int[] $ids
     * @return Node[]
     */
    public function commonNodes(array $ids): array
    {
        return array_map(function(int $id) {
            $ids =  $this->store->readNode($id);
            return new Node($id, $ids, $this->store);
        }, $this->store->commonNodes($ids));
    }

    /**
     * @param Node $selectorNode
     * @param Node[] $nodes
     * @return Node[]
     */
    public function filter(Node $selectorNode, array $nodes): array
    {
        $selectedNodes = [];
        foreach ($nodes as $node) {
            if ($node->has($selectorNode)) {
                $selectedNodes[] = $node;
            }
        }

        return $selectedNodes;
    }
}