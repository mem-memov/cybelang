<?php

namespace MemMemov\Cybelang\GraphStore;

use MemMemov\Cybelang\SpaceGraph\Node\Store;

class GraphStore implements Store
{
    /** @var NodeStore */
    private $nodeStore;
    /** @var ValueStore */
    private $valueStore;

    /**
     * 
     * @param NodeStore $nodeStore
     * @param ValueStore $valueStore
     */
    public function __construct(
        NodeStore $nodeStore,
        ValueStore $valueStore
    ) {
        $this->nodeStore = $nodeStore;
        $this->valueStore = $valueStore;
    }

    /**
     * 
     * @return int
     */
    public function createNode(): int
    {
        return $this->nodeStore->create();
    }

    /**
     * 
     * @param int $id
     * @return array
     * @throws NodeUnknown
     */
    public function readNode(int $id): array
    {
        if (!$this->nodeStore->exists($id)) {
            throw new NodeUnknown($id);
        }
        
        return $this->nodeStore->read($id);
    }

    /**
     * 
     * @param int $fromId
     * @param int $toId
     * @throws NodeUnknown
     */
    public function connectNodes(int $fromId, int $toId): void
    {
        if (!$this->nodeStore->exists($fromId)) {
            throw new NodeUnknown($fromId);
        }
        
        if (!$this->nodeStore->exists($toId)) {
            throw new NodeUnknown($toId);
        }
        
        $this->nodeStore->connect($fromId, $toId);
    }

    /**
     * 
     * @param string $value
     * @return int
     */
    public function provideNode(string $value): int
    {
        if ($this->valueStore->hasValue($value)) {
            $id = (int)$this->valueStore->key($value);
        } else {
            $id = $this->nodeStore->create();
            $this->valueStore->bind((string)$id, $value);
        }

        return $id;
    }

    /**
     * 
     * @param int $id
     * @return string
     * @throws NodeUnknown
     * @throws SomeNodesHaveNoValue
     */
    public function readValue(int $id): string
    {
        if (!$this->nodeStore->exists($id)) {
            throw new NodeUnknown($id);
        }
        
        $key = (string)$id;

        if (!$this->valueStore->hasKey($key)) {
            throw new SomeNodesHaveNoValue(sprintf('No value for key %s', $key));
        }

        return $this->valueStore->value($key);
    }

    /**
     * 
     * @param array $ids
     * @return array
     * @throws NodeUnknown
     */
    public function commonNodes(array $ids): array
    {
        foreach ($ids as $id) {
            if (!$this->nodeStore->exists($id)) {
                throw new NodeUnknown($id);
            }
        }
        
        return $this->nodeStore->intersect($ids);
    }
    
    /**
     * 
     * @param int $id
     * @param int $oldId
     * @param int $newId
     * @throws NodeUnknown
     * @throws NodeExchangesNodeItContains
     */
    public function exchangeNodes(int $id, int $oldId, int $newId): void
    {
        if (!$this->nodeStore->exists($id)) {
            throw new NodeUnknown($id);
        }
        
        if (!$this->nodeStore->exists($oldId)) {
            throw new NodeUnknown($oldId);
        }
        
        if (!$this->nodeStore->exists($newId)) {
            throw new NodeUnknown($newId);
        }
        
        if (!$this->nodeStore->contains($id, $oldId)) {
           throw new NodeExchangesNodeItContains();
        }
        
        $this->nodeStore->exchange($id, $oldId, $newId);
    }
}