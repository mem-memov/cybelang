<?php

namespace MemMemov\Cybelang\SpaceGraph\Node;

class NodeCache
{
    private $instances;

    public function __construct()
    {
        $this->instances = [];
    }

    public function set(Node $node)
    {
        $nodeId = $node->id();

        if (
            $this->has($nodeId)
            && $this->get($nodeId) !== $node
        ) {
            throw new ForbidNonUniqueInstancesInCache($nodeId);
        }

        $this->instances[$nodeId] = $node;
    }

    public function has(int $id): bool
    {
        return array_key_exists($id, $this->instances);
    }

    public function get(int $id): Node
    {
        if (!$this->has($id)) {
            throw new ComplainAboutItemsMissingInCache($id);
        }

        return $this->instances[$id];
    }
}