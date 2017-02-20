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

    public function read(int $id): Node
    {
        $ids = $this->store->readNode($id);

        return new Node($id, $ids, $this->store);
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
}