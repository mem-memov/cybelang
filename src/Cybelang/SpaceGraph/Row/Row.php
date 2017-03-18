<?php

namespace MemMemov\Cybelang\SpaceGraph\Row;

use MemMemov\Cybelang\SpaceGraph\Node\Node;
use MemMemov\Cybelang\SpaceGraph\Space\Space;

class Row
{
    private $headNode;
    private $tailSpace;
    
    public function __construct(
        Node $headNode, 
        Space $tailSpace
    ) {
        $this->headNode = $headNode;
        $this->tailSpace = $tailSpace;
    }
    
    /**
     * 
     * @param int $limit
     * @return Node[]
     * @throws ForbidRowForking
     */
    public function show(int $limit): array
    {
        $tailNodes = [];
        $node = $this->headNode;
        for ($i = 0; $i < $limit; $i++) {
            $nodes = $this->tailSpace->findNodes($node);
            $nodeCount = count($nodes);

            if (0 === $nodeCount) {
                break;
            }
            
            if ($nodeCount > 1) {
                throw new ForbidRowForking();
            }
            
            if (1 === $nodeCount) {
                $node = array_pop($nodes);
                $tailNodes[] = $node;
            }
        }
        
        return $tailNodes;
    }
    
    public function grow(Node $newTailNode): void
    {
        $nodes = $this->tailSpace->findNodes($this->headNode);
        $nodeCount = count($nodes);
        
        if (0 === $nodeCount) {
            $this->headNode->add($newTailNode);
            $newTailNode->add($this->headNode);
        }
        
        if ($nodeCount > 1) {
            throw new ForbidRowForking();
        }
        
        if (1 === $nodeCount) {
            $oldTailNode = array_pop($nodes);
            if ($oldTailNode->id() > $newTailNode->id()) {
                throw new ForbidRowCycles();
            }
            $this->headNode->exchange($oldTailNode, $newTailNode);
            $newTailNode->add($oldTailNode);
            $newTailNode->add($this->headNode);
        }
    }
}
