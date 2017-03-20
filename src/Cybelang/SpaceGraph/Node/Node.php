<?php

namespace MemMemov\Cybelang\SpaceGraph\Node;

class Node
{
    private $id;
    private $ids;
    private $store;

    public function __construct(
        int $id,
        array $ids,
        Store $store
    ) {
        $this->id = $id;
        $this->ids = array_map(function(int $id) {
            return $id;
        }, $ids);
        $this->store = $store;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function has(Node $node): bool
    {
        return in_array($node->id(), $this->ids);
    }

    /**
     * @param Node[] $nodes
     * @return bool
     */
    public function in(array $nodes): bool
    {
        foreach ($nodes as $node) {
            if ($node->id() === $this->id) {
                return true;
            }
        }

        return false;
    }
    
    /**
     * @return Node[]
     */
    public function all(): array
    {
        return array_map(function(int $id) {
            $ids = $this->store->readNode($id);
            return new Node($id, $ids, $this->store);
        }, $this->ids);
    }

    public function add(Node $node): void
    {
        $nodeId = $node->id();

        if (in_array($nodeId, $this->ids)) {
            return;
        }

        $this->store->connectNodes($this->id, $nodeId);
        
        $this->ids[] = $nodeId;
    }
    
    public function exchange(Node $oldNode, Node $newNode): void
    {
        $oldNodeId = $oldNode->id();
        $newNodeId = $newNode->id();
        
        $index = array_search($oldNodeId, $this->ids);
        
        if (false === $index) {
            throw new ForbidExchangingMissingNode();
        }
        
        $this->store->exchangeNodes($this->id, $oldNodeId, $newNodeId);
        $this->ids[$index] = $newNodeId;
    }
}