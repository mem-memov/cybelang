<?php

namespace MemMemov\SpaceGraph;

class NodeCache
{
    private $instances;

    public function __construct()
    {
        $this->instances = [];
    }

    public function set(Node $node)
    {
        if (
            $this->has($node->id())
            && $this->get($node->id()) !== $node
        ) {
            throw new ForbidNonUniqueInstancesInNodeCache($node->id());
        }

        $this->instances[$node->id()] = $node;
    }

    public function has(int $id): bool
    {
        return array_key_exists($id, $this->instances);
    }

    public function get(int $id): Node
    {
        if (!$this->has($id)) {
            throw new ComplainAboutNodesMissingInNodeCache($id);
        }

        return $this->instances[$id];
    }
}