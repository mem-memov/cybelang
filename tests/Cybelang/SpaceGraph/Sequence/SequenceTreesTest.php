<?php

namespace MemMemov\Cybelang\SpaceGraph\Sequence;

use MemMemov\Cybelang\SpaceGraph\Node\{Node, Nodes};
use MemMemov\Cybelang\SpaceGraph\Space\{Space, Spaces};
use PHPUnit\Framework\TestCase;

class SequenceTreesTest extends TestCase
{
    /** @var Nodes|\PHPUnit_Framework_MockObject_MockObject */
    protected $nodes;
    /** @var Spaces|\PHPUnit_Framework_MockObject_MockObject */
    protected $spaces;
    
    protected function setUp()
    {
        $this->nodes = $this->createMock(Nodes::class);
        $this->spaces = $this->createMock(Spaces::class);
    }
    
    public function testItForbidsEmptySequence()
    {
        $sequenceTrees = new SequenceTrees($this->nodes, $this->spaces);
        
        $treeSpaceName = 'phrase';
        
        $this->expectException(ForbidEmptySequence::class);
        
        $sequenceTrees->create($treeSpaceName, []);
    }
    
    public function testItCreatesFirstTreeInSequence()
    {
        $sequenceTrees = new SequenceTrees($this->nodes, $this->spaces);
        
        $treeSpaceName = 'phrase';
        
        $sequenceNode = $this->createMock(Node::class);
        
        $treeSpace = $this->createMock(Space::class);
        
        $this->spaces->expects($this->once())
            ->method('provideSpace')
            ->with($treeSpaceName)
            ->willReturn($treeSpace);
        
        $treeNode = $this->createMock(Node::class);
        
        $treeSpace->expects($this->once())
            ->method('createCommonNode')
            ->with([$sequenceNode])
            ->willReturn($treeNode);
        
        $result = $sequenceTrees->create($treeSpaceName, [$sequenceNode]);
        
        $this->assertInstanceOf(SequenceTree::class, $result);
    }
    
    public function testItCreatesNextTreeInSequence()
    {
        $sequenceTrees = new SequenceTrees($this->nodes, $this->spaces);
        
        $treeSpaceName = 'phrase';
        
        $sequenceNode_1 = $this->createMock(Node::class);
        $sequenceNode_2 = $this->createMock(Node::class);
        
        $treeSpace = $this->createMock(Space::class);
        
        $this->spaces->expects($this->once())
            ->method('provideSpace')
            ->with($treeSpaceName)
            ->willReturn($treeSpace);
        
        // iteration 1
        
        $treeSpace->expects($this->at(0))
            ->method('findNodes')
            ->with($sequenceNode_1)
            ->willReturn([]);

        $treeNode_1 = $this->createMock(Node::class);
        
        $treeSpace->expects($this->at(1))
            ->method('createCommonNode')
            ->with([$sequenceNode_1])
            ->willReturn($treeNode_1);
        
        // iteration 2
        
        $treeSpace->expects($this->at(2))
            ->method('findNodes')
            ->with($sequenceNode_2)
            ->willReturn([]);
        
        $treeNode_2 = $this->createMock(Node::class);
        
        $treeSpace->expects($this->at(3))
            ->method('createCommonNode')
            ->with([$treeNode_1, $sequenceNode_2])
            ->willReturn($treeNode_2);
        
        $result = $sequenceTrees->create($treeSpaceName, [$sequenceNode_1, $sequenceNode_2]);
        
        $this->assertInstanceOf(SequenceTree::class, $result);
    }
    
    public function testItSuppliesSequenceTree()
    {
        $sequenceTrees = new SequenceTrees($this->nodes, $this->spaces);
        
        $sequenceSpaceName = 'word';
        $treeNodeId = 54;
        
        $treeNode = $this->createMock(Node::class);
        
        $this->nodes->expects($this->once())
            ->method('read')
            ->with($treeNodeId)
            ->willReturn($treeNode);
        
        $sequenceSpace = $this->createMock(Space::class);
        
        $this->spaces->expects($this->once())
            ->method('provideSpace')
            ->with($sequenceSpaceName)
            ->willReturn($sequenceSpace);
        
        $sequenceNode = $this->createMock(Node::class);
        
        $sequenceSpace->expects($this->once())
            ->method('getOneNode')
            ->with($treeNode)
            ->willReturn($sequenceNode);
        
        $result = $sequenceTrees->get($sequenceSpaceName, $treeNodeId);
        
        $this->assertInstanceOf(SequenceTree::class, $result);        
    }
}
