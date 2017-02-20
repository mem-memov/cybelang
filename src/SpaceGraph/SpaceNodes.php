<?php

namespace MemMemov\SpaceGraph;

class SpaceNodes
{
    private $nodes;
    private $spaces;

    public function __construct(
        Nodes $nodes,
        Spaces $spaces
    ) {
        $this->nodes = $nodes;
        $this->spaces = $spaces;
    }

    public function read(string $space, int $id): SpaceNode
    {
        $node = $this->nodes->read($id);

        return new SpaceNode($node, $this->spaces);
    }
}