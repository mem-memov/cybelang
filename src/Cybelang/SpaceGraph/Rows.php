<?php

namespace MemMemov\Cybelang\SpaceGraph;

class Rows
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
    
    public function createUsingHead(int $headId, string $tailSpaceName): Row
    {
        $headNode = $this->nodes->read($headId);
        $tailSpace = $this->spaces->provideSpace($tailSpaceName);
        
        return new Row($headNode, $tailSpace);
    }
}
