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

    public function read(string $spaceName, int $id): SpaceNode
    {
        $node = $this->nodes->read($id);
        $space = $this->spaces->spaceOfNode($node);
        

        return new SpaceNode($node, $this->spaces);
    }
}