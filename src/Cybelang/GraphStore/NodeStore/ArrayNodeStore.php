<?php

namespace MemMemov\Cybelang\GraphStore\NodeStore;

use MemMemov\Cybelang\GraphStore\NodeStore as NodeStoreInterface;
use Psr\Log\LoggerInterface;

class ArrayNodeStore implements NodeStoreInterface
{
    private $path;
    private $store;

    public function __construct(
        string $path
    ) {
        $this->path = $path;

        $this->store = [];
        if (file_exists($this->path)) {
            $contents = file_get_contents($this->path);
            if (!empty($contents)) {
                $this->store = unserialize($contents);
            }
        }
    }

    public function create(): int
    {
        $id = count($this->store) + 1;

        $this->store[$id] = [];
        file_put_contents($this->path, serialize($this->store));

        return $id;
    }

    public function read(int $id): array
    {
        return $this->store[$id];
    }

    public function connect(int $fromId, int $toId): void
    {
        if (
            array_key_exists($fromId, $this->store)
            && is_array($this->store[$fromId])
            && in_array($toId, $this->store[$fromId])
        ) {
            return;
        }

        $this->store[$fromId][] = $toId;
        file_put_contents($this->path, serialize($this->store));
    }

    public function contains(int $fromId, int $toId): bool
    {
        return in_array($toId, $this->store[$fromId]);
    }

    public function intersect(array $fromIds): array
    {
        $toIds = [];

        foreach ($fromIds as $fromId) {
            $toIds[] = $this->store[$fromId];
        }

        $uniqueToIds = array_unique(call_user_func_array('array_merge', $toIds));

        $arguments = $toIds;
        array_unshift($arguments, $uniqueToIds);

        return call_user_func_array('array_intersect', $arguments);
    }
    
    public function exchange(int $id, int $oldId, int $newId): void
    {
        $index = array_search($oldId, $this->store[$id]);
      
        if (false !== $index) {
            $this->store[$id][$index] = $newId;
            file_put_contents($this->path, serialize($this->store));
        }
    }

    public function exists(int $id): bool
    {
        return array_key_exists($id, $this->store);
    }
}