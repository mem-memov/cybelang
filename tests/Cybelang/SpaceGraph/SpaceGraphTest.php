<?php

namespace MemMemov\Cybelang\SpaceGraph;

use MemMemov\Cybelang\Cybe\GraphNode;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class SpaceGraphTest extends TestCase
{
    /** @var SpaceNodesInGraph|\PHPUnit_Framework_MockObject_MockObject */
    protected $spaceNodes;
    /** @var LoggerInterface|\PHPUnit_Framework_MockObject_MockObject */
    protected $logger;

    protected function setUp()
    {
        $this->spaceNodes = $this->createMock(SpaceNodesInGraph::class);
        $this->logger = $this->createMock(LoggerInterface::class);
    }
    
    public function testItCreatesNode()
    {
        $spaceGraph = new SpaceGraph($this->spaceNodes, $this->logger);
        
        $type = 'message';
        $toIds = [600076, 2451];
        $fromIds = [300, 11];
        
        $graphNode = $this->createMock(SpaceNode::class);
        
        $this->spaceNodes->expects($this->once())
            ->method('createNode')
            ->with($type, $toIds, $fromIds)
            ->willReturn($graphNode);
        
        $result = $spaceGraph->createNode($type, $toIds, $fromIds);
        
        $this->assertSame($graphNode, $result);
    }
    
    public function testItProvidesCommonNode()
    {
        $spaceGraph = new SpaceGraph($this->spaceNodes, $this->logger);
        
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
        $spaceGraph = new SpaceGraph($this->spaceNodes, $this->logger);
        
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
        $spaceGraph = new SpaceGraph($this->spaceNodes, $this->logger);
        
        $id = 4099;
        $value = 'cat';

        $this->spaceNodes->expects($this->once())
            ->method('valueOfNode')
            ->with($id)
            ->willReturn($value);
        
        $result = $spaceGraph->getNodeValue($id);
        
        $this->assertSame($value, $result);
    }
    
    public function testItReadsNode()
    {
        $spaceGraph = new SpaceGraph($this->spaceNodes, $this->logger);
        
        $id = 4099;

        $graphNode = $this->createMock(SpaceNode::class);

        $this->spaceNodes->expects($this->once())
            ->method('readNode')
            ->with($id)
            ->willReturn($graphNode);
        
        $result = $spaceGraph->readNode($id);
        
        $this->assertSame($graphNode, $result);
    }
    
    public function testItFiltersNode()
    {
        $spaceGraph = new SpaceGraph($this->spaceNodes, $this->logger);
        
        $type = 'clause';
        $id = 4099;
        
        $graphNode = $this->createMock(SpaceNode::class);
        
        $this->spaceNodes->expects($this->once())
            ->method('filterNode')
            ->with($type, $id)
            ->willReturn([$graphNode]);
        
        $result = $spaceGraph->filterNode($type, $id);
        
        $this->assertSame([$graphNode], $result);
    }
    
    public function testItProvidesSequenceNode()
    {
        $spaceGraph = new SpaceGraph($this->spaceNodes, $this->logger);
        
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
        $spaceGraph = new SpaceGraph($this->spaceNodes, $this->logger);
        
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
    
    public function testItAddsNodeToRow()
    {
        $spaceGraph = new SpaceGraph($this->spaceNodes, $this->logger);
        
        $headId = 10;
        $newTailId = 4032;
        
        $this->spaceNodes->expects($this->once())
            ->method('addNodeToRow')
            ->with($headId, $newTailId);
        
        $spaceGraph->addNodeToRow($headId, $newTailId);
    }
    
    public function testItReadsRow()
    {
        $spaceGraph = new SpaceGraph($this->spaceNodes, $this->logger);
        
        $tailSpaceName = 'message';
        $headId = 75345;
        $limit = 100;
        
        $tailNode = $this->createMock(SpaceNode::class);
        
        $this->spaceNodes->expects($this->once())
            ->method('readRow')
            ->with($tailSpaceName, $headId, $limit)
            ->willReturn([$tailNode]);
        
        $result = $spaceGraph->readRow($tailSpaceName, $headId, $limit);
        
        $this->assertSame([$tailNode], $result);
    }
}
