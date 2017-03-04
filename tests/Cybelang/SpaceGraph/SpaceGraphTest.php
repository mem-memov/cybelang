<?php

namespace MemMemov\Cybelang\SpaceGraph;

use MemMemov\Cybelang\Cybe\GraphNode;
use PHPUnit\Framework\TestCase;

class SpaceGraphTest extends TestCase
{
    /** @var SpaceNodesInGraph|\PHPUnit_Framework_MockObject_MockObject */
    protected $spaceNodes;

    protected function setUp()
    {
        $this->spaceNodes = $this->createMock(SpaceNodesInGraph::class);
    }
    
    public function testItProvidesCommonNode()
    {
        $spaceGraph = new SpaceGraph($this->spaceNodes);
        
        $type = 'clause';
        $ids = [4, 5];
        
        $graphNode = $this->createMock(SpaceNode::class);
        
        $this->spaceNodes->expects($this->once())
            ->method('provideCommonNode')
            ->with($type, $ids)
            ->willReturn($graphNode);
        
        $result = $spaceGraph->provideCommonNode($type, $ids);
        
        $this->assertSame($graphNode, $result);
    }
    
    public function testItProvidesValueNode()
    {
        $spaceGraph = new SpaceGraph($this->spaceNodes);
        
        $type = 'word';
        $value = 'cat';
        
        $graphNode = $this->createMock(SpaceNode::class);
        
        $this->spaceNodes->expects($this->once())
            ->method('provideNodeForValue')
            ->with($type, $value)
            ->willReturn($graphNode);
        
        $result = $spaceGraph->provideValueNode($type, $value);
        
        $this->assertSame($graphNode, $result);
    }
    
    public function testItSuppliesNodeValue()
    {
        $spaceGraph = new SpaceGraph($this->spaceNodes);
        
        $id = 4099;
        $value = 'cat';

        $this->spaceNodes->expects($this->once())
            ->method('valueOfNode')
            ->with($id)
            ->willReturn($value);
        
        $result = $spaceGraph->getNodeValue($id);
        
        $this->assertSame($value, $result);
    }
    
    public function testItreadsNode()
    {
        $spaceGraph = new SpaceGraph($this->spaceNodes);
        
        $id = 4099;

        $graphNode = $this->createMock(SpaceNode::class);

        $this->spaceNodes->expects($this->once())
            ->method('readNode')
            ->with($id)
            ->willReturn($graphNode);
        
        $result = $spaceGraph->readNode($id);
        
        $this->assertSame($graphNode, $result);
    }
    
    public function testItProvidesSequenceNode()
    {
        $spaceGraph = new SpaceGraph($this->spaceNodes);
        
        $type = 'clause';
        $ids = [4, 5];
        
        $graphNode = $this->createMock(SpaceNode::class);
        
        $this->spaceNodes->expects($this->once())
            ->method('provideSequenceNode')
            ->with($type, $ids)
            ->willReturn($graphNode);
        
        $result = $spaceGraph->provideSequenceNode($type, $ids);
        
        $this->assertSame($graphNode, $result);
    }
    
    public function testItReadSequenceNodes()
    {
        $spaceGraph = new SpaceGraph($this->spaceNodes);
        
        $type = 'clause';
        $id = 356348;
        
        $graphNode = $this->createMock(SpaceNode::class);
        
        $this->spaceNodes->expects($this->once())
            ->method('readNodeSequence')
            ->with($type, $id)
            ->willReturn([$graphNode]);
        
        $result = $spaceGraph->readSequenceNodes($type, $id);
        
        $this->assertSame([$graphNode], $result);
    }
}
