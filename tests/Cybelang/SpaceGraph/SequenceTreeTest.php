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
    
    public function testItChecksItHasPreviousItem()
    {
        $sequenceTree = new SequenceTree($this->treeNode, $this->sequenceNode, $this->nodes, $this->spaces);
        
        $treeSpace = $this->createMock(Space::class);
        
        $this->spaces->expects($this->once())
                ->method('spaceOfNode')
                ->with($this->treeNode)
                ->willReturn($treeSpace);
        
        $previousTreeNode = $this->createMock(Node::class);
        
        $treeSpace->expects($this->once())
                ->method('findNodes')
                ->with($this->treeNode)
                ->willReturn([$previousTreeNode]);
        
        $result = $sequenceTree->hasPreviousTree();
        
        $this->assertTrue($result);
    }
    
    public function testItChecksItHasNoPreviousItem()
    {
        $sequenceTree = new SequenceTree($this->treeNode, $this->sequenceNode, $this->nodes, $this->spaces);
        
        $treeSpace = $this->createMock(Space::class);
        
        $this->spaces->expects($this->once())
                ->method('spaceOfNode')
                ->with($this->treeNode)
                ->willReturn($treeSpace);

        $treeSpace->expects($this->once())
                ->method('findNodes')
                ->with($this->treeNode)
                ->willReturn([]);
        
        $result = $sequenceTree->hasPreviousTree();
        
        $this->assertFalse($result);
    }
    
    public function testItForbidsSequenceTreeToHaveManySubtrees()
    {
        $sequenceTree = new SequenceTree($this->treeNode, $this->sequenceNode, $this->nodes, $this->spaces);
        
        $treeSpace = $this->createMock(Space::class);
        
        $this->spaces->expects($this->once())
                ->method('spaceOfNode')
                ->with($this->treeNode)
                ->willReturn($treeSpace);
        
        $previousTreeNode_1 = $this->createMock(Node::class);
        $previousTreeNode_2 = $this->createMock(Node::class);
        
        $treeSpace->expects($this->once())
                ->method('findNodes')
                ->with($this->treeNode)
                ->willReturn([$previousTreeNode_1, $previousTreeNode_2]);
        
        $this->expectException(ForbidSequenceTreeToHaveManySubtrees::class);
        
        $sequenceTree->hasPreviousTree();
    }
    
    public function testItForbidsMissingSequenceSubtree()
    {
        $sequenceTree = $this->getMockBuilder(SequenceTree::class)
                ->setMethods(['hasPreviousTree'])
                ->setConstructorArgs([$this->treeNode, $this->sequenceNode, $this->nodes, $this->spaces])
                ->getMock();
        
        $sequenceTree->expects($this->once())
                ->method('hasPreviousTree')
                ->willReturn(false);
        
        $this->expectException(ForbidMissingSequenceSubtree::class);
        
        $sequenceTree->getPreviousTree();
    }
    
    public function testItSuppliesPreviousSubtree()
    {
        $sequenceTree = $this->getMockBuilder(SequenceTree::class)
                ->setMethods(['hasPreviousTree'])
                ->setConstructorArgs([$this->treeNode, $this->sequenceNode, $this->nodes, $this->spaces])
                ->getMock();
        
        $sequenceTree->expects($this->once())
                ->method('hasPreviousTree')
                ->willReturn(true);
        
        $treeSpace = $this->createMock(Space::class);
        
        $this->spaces->expects($this->at(0))
                ->method('spaceOfNode')
                ->with($this->treeNode)
                ->willReturn($treeSpace);
        
        $previousTreeNode = $this->createMock(Node::class);
        
        $treeSpace->expects($this->once())
                ->method('findNodes')
                ->with($this->treeNode)
                ->willReturn([$previousTreeNode]);
        
        $sequenceSpace = $this->createMock(Space::class);
        
        $this->spaces->expects($this->at(1))
                ->method('spaceOfNode')
                ->with($this->sequenceNode)
                ->willReturn($sequenceSpace);
        
        $sequenceNode = $this->createMock(Node::class);
        
        $sequenceSpace->expects($this->once())
                ->method('getOneNode')
                ->with($previousTreeNode)
                ->willReturn($sequenceNode);
        
        $result = $sequenceTree->getPreviousTree();
        
        $this->assertInstanceOf(SequenceTree::class, $result);
    }
    
    public function testItStartsCollectingSequenceNodes()
    {
        $sequenceTree = $this->getMockBuilder(SequenceTree::class)
                ->setMethods(['hasPreviousTree'])
                ->setConstructorArgs([$this->treeNode, $this->sequenceNode, $this->nodes, $this->spaces])
                ->getMock();
        
        $sequenceTree->expects($this->once())
                ->method('hasPreviousTree')
                ->willReturn(false);

        $result = $sequenceTree->collectSequenceNodes();
        
        $this->assertSame([$this->sequenceNode], $result);
    }
    
    public function testItContinuesCollectingSequenceNodes()
    {
        $sequenceTree = $this->getMockBuilder(SequenceTree::class)
                ->setMethods(['hasPreviousTree', 'getPreviousTree'])
                ->setConstructorArgs([$this->treeNode, $this->sequenceNode, $this->nodes, $this->spaces])
                ->getMock();
        
        $sequenceTree->expects($this->once())
                ->method('hasPreviousTree')
                ->willReturn(true);
        
        $previousTree = $this->createMock(SequenceTree::class);
        
        $sequenceTree->expects($this->once())
                ->method('getPreviousTree')
                ->willReturn($previousTree);
        
        $previousSequenceNode = $this->createMock(Node::class);
        
        $previousTree->expects($this->once())
                ->method('collectSequenceNodes')
                ->willReturn([$previousSequenceNode]);

        $result = $sequenceTree->collectSequenceNodes();
        
        $this->assertSame([$previousSequenceNode, $this->sequenceNode], $result);
    }
}
