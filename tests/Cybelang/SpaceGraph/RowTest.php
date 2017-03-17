<?php

namespace MemMemov\Cybelang\SpaceGraph;

use PHPUnit\Framework\TestCase;

class RowTest extends TestCase
{
    /** @var Node|\PHPUnit_Framework_MockObject_MockObject */
    protected $headNode;
    /** @var Space|\PHPUnit_Framework_MockObject_MockObject */
    protected $tailSpace;

    protected function setUp()
    {
        $this->headNode = $this->createMock(Node::class);
        $this->tailSpace = $this->createMock(Space::class);        
    }
    
    public function testItShowsLastAddedTailNodesInReversedOrder()
    {
        $row = new Row($this->headNode, $this->tailSpace);
        
        $limit = 2000;
        
        $tailNode_1 = $this->createMock(Node::class);
        $tailNode_2 = $this->createMock(Node::class);
        
        $this->tailSpace->expects($this->at(0))
            ->method('findNodes')
            ->with($this->headNode)
            ->willReturn([$tailNode_2]);
        
        $this->tailSpace->expects($this->at(1))
            ->method('findNodes')
            ->with($tailNode_2)
            ->willReturn([$tailNode_1]);
        
        $result = $row->show($limit);
        
        $this->assertSame([$tailNode_2, $tailNode_1], $result);
    }
    
    public function testItShowsNoTailNodesIfItHasOnlyHeadNode()
    {
        $row = new Row($this->headNode, $this->tailSpace);
        
        $limit = 2000;
        
        $this->tailSpace->expects($this->once())
            ->method('findNodes')
            ->with($this->headNode)
            ->willReturn([]);
        
        $result = $row->show($limit);
        
        $this->assertSame([], $result);
    }
    
    public function testItForbidsRowForking()
    {
        $row = new Row($this->headNode, $this->tailSpace);
        
        $limit = 2000;
        
        $tailNode_1 = $this->createMock(Node::class);
        $tailNode_2 = $this->createMock(Node::class);
        
        $this->tailSpace->expects($this->at(0))
            ->method('findNodes')
            ->with($this->headNode)
            ->willReturn([$tailNode_1, $tailNode_2]);
        
        $this->expectException(ForbidRowForking::class);
        
        $row->show($limit);
    }
    
    public function testItLimitsNumberOfShownTailNodes()
    {
        $row = new Row($this->headNode, $this->tailSpace);
        
        $limit = 1;
        
        $tailNode_1 = $this->createMock(Node::class);
        $tailNode_2 = $this->createMock(Node::class);
        
        $this->tailSpace->expects($this->any())
            ->method('findNodes')
            ->withConsecutive([$this->headNode], [$tailNode_2])
            ->will($this->onConsecutiveCalls([$tailNode_2], [$tailNode_1]));
        
        $result = $row->show($limit);
        
        $this->assertSame([$tailNode_2], $result);
    }
    
    public function testItsNeckGrows()
    {
        $row = new Row($this->headNode, $this->tailSpace);
        
        $newTailNode = $this->createMock(Node::class);
        $oldTailNode = $this->createMock(Node::class);
        
        $this->tailSpace->expects($this->once())
            ->method('findNodes')
            ->with($this->headNode)
            ->willReturn([$oldTailNode]);
        
        $oldTailNode->expects($this->once())
            ->method('id')
            ->willReturn(5);
        
        $newTailNode->expects($this->at(0))
            ->method('id')
            ->willReturn(501);
        
        $this->headNode->expects($this->once())
            ->method('exchange')
            ->with($oldTailNode, $newTailNode);
        
        $newTailNode->expects($this->at(1))
            ->method('add')
            ->with($oldTailNode);
       
        $newTailNode->expects($this->at(2))
            ->method('add')
            ->with($this->headNode);
              
        $row->grow($newTailNode);
    }
    
    public function testItForbidsRowForkingWhenGrowing()
    {
        $row = new Row($this->headNode, $this->tailSpace);
        
        $newTailNode = $this->createMock(Node::class);
        $oldTailNode_1 = $this->createMock(Node::class);
        $oldTailNode_2 = $this->createMock(Node::class);
        
        $this->tailSpace->expects($this->once())
            ->method('findNodes')
            ->with($this->headNode)
            ->willReturn([$oldTailNode_1, $oldTailNode_2]);
        
        $this->expectException(ForbidRowForking::class);
              
        $row->grow($newTailNode);
    }
    
    public function testItStartsGrowingItsTailFromItsHead()
    {
        $row = new Row($this->headNode, $this->tailSpace);
        
        $newTailNode = $this->createMock(Node::class);
        
        $this->tailSpace->expects($this->once())
            ->method('findNodes')
            ->with($this->headNode)
            ->willReturn([]);
        
        $this->headNode->expects($this->once())
            ->method('add')
            ->with($newTailNode);
        
        $newTailNode->expects($this->once())
            ->method('add')
            ->with($this->headNode);
              
        $row->grow($newTailNode);
    }
    
    public function testItForbidsRowCycles()
    {
        $row = new Row($this->headNode, $this->tailSpace);
        
        $newTailNode = $this->createMock(Node::class);
        $oldTailNode = $this->createMock(Node::class);
        
        $this->tailSpace->expects($this->once())
            ->method('findNodes')
            ->with($this->headNode)
            ->willReturn([$oldTailNode]);
        
        $oldTailNode->expects($this->once())
            ->method('id')
            ->willReturn(5);
        
        $newTailNode->expects($this->once())
            ->method('id')
            ->willReturn(1);

        $this->expectException(ForbidRowCycles::class);
              
        $row->grow($newTailNode);
    }
}
