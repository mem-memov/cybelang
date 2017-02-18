<?php

namespace MemMemov\SpaceGraph;

use MemMemov\Cybe\GraphNode;

class Node implements GraphNode
{
    private $id;
    private $ids;
    private $nodes;

    public function __construct(
        int $id,
        array $ids,
        Nodes $nodes
    ) {
        $this->id = $id;
        $this->ids = array_map(function(int $id) {
            return $id;
        }, $ids);
        $this->nodes = $nodes;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function one(string $type): GraphNode
    {
        $ids = $this->store->readNode($this->id);
        $space = $this->spaces->provideSpace($type);


    }

    public function all(string $type, callable $use): void
    {

    }
}