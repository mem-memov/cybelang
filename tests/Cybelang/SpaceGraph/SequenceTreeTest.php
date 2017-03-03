<?php

namespace MemMemov\Cybelang\SpaceGraph;

use PHPUnit\Framework\TestCase;

class SequenceTreeTest extends TestCase 
{
    /** @var Node|\PHPUnit_Framework_MockObject_MockObject */
    protected $treeNode;
    
    /** @var Node|\PHPUnit_Framework_MockObject_MockObject */
    protected $sequenceNode;
    
    /** @var Nodes|\PHPUnit_Framework_MockObject_MockObject */
    protected $nodes;
    
    /** @var Spaces|\PHPUnit_Framework_MockObject_MockObject */
    protected $spaces;
    
    protected function setup() 
    {
        $this->treeNode = $this->createMock(Node::class);
        $this->sequenceNode = $this->createMock(Node::class);
        $this->nodes = $this->createMock(Nodes::class);
        $this->spaces = $this->createMock(Spaces::class);
    }

    public function testItSuppliesTreeNode()
    {
        $sequenceTree = new SequenceTree($this->treeNode, $this->sequenceNode, $this->nodes, $this->spaces);
        
        $result = $sequenceTree->getTreeNode();
        
        $this->assertSame($result, $this->treeNode);
    }

    public function testItSuppliesSequenceNode()
    {
        $sequenceTree = new SequenceTree($this->treeNode, $this->sequenceNode, $this->nodes, $this->spaces);
        
        $result = $sequenceTree->getSequenceNode();
        
        $this->assertSame($result, $this->sequenceNode);
    }
}
