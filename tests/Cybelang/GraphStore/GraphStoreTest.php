<?php

namespace MemMemov\Cybelang\GraphStore;

use Psr\Log\LoggerInterface;
use PHPUnit\Framework\TestCase;

class GraphStoreTest extends TestCase
{
    /** @var NodeStore|\PHPUnit_Framework_MockObject_MockObject */
    protected $nodeStore;
    /** @var ValueStore|\PHPUnit_Framework_MockObject_MockObject */
    protected $valueStore;
    /** @var LoggerInterface|\PHPUnit_Framework_MockObject_MockObject */
    protected $logger;


    protected function setUp()
    {
        $this->nodeStore = $this->createMock(NodeStore::class);
        $this->valueStore = $this->createMock(ValueStore::class);
        $this->logger = $this->createMock(LoggerInterface::class);
    }

    public function testItCreatesNode()
    {
        $graphStore = new GraphStore($this->nodeStore, $this->valueStore, $this->logger);

        $id = 765;

        $this->nodeStore->expects($this->once())
            ->method('create')
            ->willReturn($id);

        $result = $graphStore->createNode();

        $this->assertEquals($id, $result);
    }

    public function testItReadsNode()
    {
        $graphStore = new GraphStore($this->nodeStore, $this->valueStore, $this->logger);

        $id = 765;
        $ids = [5, 7, 99];

        $this->nodeStore->expects($this->once())
            ->method('exists')
            ->with($id)
            ->willReturn(true);
        
        $this->nodeStore->expects($this->once())
            ->method('read')
            ->with($id)
            ->willReturn($ids);

        $result = $graphStore->readNode($id);

        $this->assertEquals($ids, $result);
    }
    
    public function testItChecksIfNodeExistsBeforeReading()
    {
        $graphStore = new GraphStore($this->nodeStore, $this->valueStore, $this->logger);
        
        $id = 765;
        
        $this->nodeStore->expects($this->once())
            ->method('exists')
            ->with($id)
            ->willReturn(false);
        
        $this->expectException(NodeUnknown::class);
        
        $graphStore->readNode($id);
    }

    public function testItConnectsNodes()
    {
        $graphStore = new GraphStore($this->nodeStore, $this->valueStore, $this->logger);

        $fromId = 754;
        $toId = 5;

        $this->nodeStore->expects($this->at(0))
            ->method('exists')
            ->with($fromId)
            ->willReturn(true);
        
        $this->nodeStore->expects($this->at(1))
            ->method('exists')
            ->with($toId)
            ->willReturn(true);
        
        $this->nodeStore->expects($this->once())
            ->method('connect')
            ->with($fromId, $toId);

        $graphStore->connectNodes($fromId, $toId);
    }
    
    
    public function testItChecksIfFromNodeExistsBeforeConnecting()
    {
        $graphStore = new GraphStore($this->nodeStore, $this->valueStore, $this->logger);
        
        $fromId = 754;
        $toId = 5;
        
        $this->nodeStore->expects($this->at(0))
            ->method('exists')
            ->with($fromId)
            ->willReturn(false);
        
        $this->expectException(NodeUnknown::class);
        
        $graphStore->connectNodes($fromId, $toId);
    }

    public function testItChecksIfToNodeExistsBeforeConnecting()
    {
        $graphStore = new GraphStore($this->nodeStore, $this->valueStore, $this->logger);
        
        $fromId = 754;
        $toId = 5;
        
        $this->nodeStore->expects($this->at(0))
            ->method('exists')
            ->with($fromId)
            ->willReturn(true);
        
        $this->nodeStore->expects($this->at(1))
            ->method('exists')
            ->with($toId)
            ->willReturn(false);
        
        $this->expectException(NodeUnknown::class);
        
        $graphStore->connectNodes($fromId, $toId);
    }

    public function testItReadsExistingNodeForValue()
    {
        $graphStore = new GraphStore($this->nodeStore, $this->valueStore, $this->logger);

        $id = 765;
        $value = 'some value';

        $this->valueStore->expects($this->once())
            ->method('hasValue')
            ->with($value)
            ->willReturn(true);

        $this->valueStore->expects($this->once())
            ->method('key')
            ->with($value)
            ->willReturn((string)$id);

        $result = $graphStore->provideNode($value);

        $this->assertEquals($id, $result);
    }

    public function testItCreatesNewNodeForValue()
    {
        $graphStore = new GraphStore($this->nodeStore, $this->valueStore, $this->logger);

        $id = 765;
        $value = 'some value';

        $this->valueStore->expects($this->once())
            ->method('hasValue')
            ->with($value)
            ->willReturn(false);

        $this->nodeStore->expects($this->once())
            ->method('create')
            ->willReturn($id);

        $this->valueStore->expects($this->once())
            ->method('bind')
            ->with((string)$id, $value);

        $result = $graphStore->provideNode($value);

        $this->assertEquals($id, $result);
    }

    public function testItReadsValueOfNode()
    {
        $graphStore = new GraphStore($this->nodeStore, $this->valueStore, $this->logger);

        $id = 765;
        $value = 'some value';
        
        $this->nodeStore->expects($this->once())
            ->method('exists')
            ->with($id)
            ->willReturn(true);

        $this->valueStore->expects($this->once())
            ->method('hasKey')
            ->with((string)$id)
            ->willReturn(true);

        $this->valueStore->expects($this->once())
            ->method('value')
            ->with((string)$id)
            ->willReturn($value);

        $result = $graphStore->readValue($id);

        $this->assertEquals($value, $result);
    }
    
    public function testItChecksIfNodeExistsBeforeReadingValue()
    {
        $graphStore = new GraphStore($this->nodeStore, $this->valueStore, $this->logger);

        $id = 765;
        
        $this->nodeStore->expects($this->once())
            ->method('exists')
            ->with($id)
            ->willReturn(false);
        
        $this->expectException(NodeUnknown::class);
        
        $graphStore->readValue($id);
    }

    public function testItDeniesReadingEmptyNode()
    {
        $graphStore = new GraphStore($this->nodeStore, $this->valueStore, $this->logger);

        $id = 765;
        
        $this->nodeStore->expects($this->once())
            ->method('exists')
            ->with($id)
            ->willReturn(true);

        $this->valueStore->expects($this->once())
            ->method('hasKey')
            ->with((string)$id)
            ->willReturn(false);

        $this->expectException(SomeNodesHaveNoValue::class);

        $graphStore->readValue($id);
    }

    public function testItFindsCommonSubnodes()
    {
        $graphStore = new GraphStore($this->nodeStore, $this->valueStore, $this->logger);

        $ids = [5, 7, 99];
        $commonSubIds = [2, 78];
        
        $this->nodeStore->expects($this->exactly(3))
            ->method('exists')
            ->withConsecutive([$ids[0]], [$ids[1]], [$ids[2]])
            ->will($this->onConsecutiveCalls(true, true, true));

        $this->nodeStore->expects($this->once())
            ->method('intersect')
            ->with($ids)
            ->willReturn($commonSubIds);

        $result = $graphStore->commonNodes($ids);

        $this->assertEquals($commonSubIds, $result);
    }
    
    public function testItChecksIfNodesExistBeforeFindingCommonNodes()
    {
        $graphStore = new GraphStore($this->nodeStore, $this->valueStore, $this->logger);

        $ids = [5];
        
        $this->nodeStore->expects($this->once())
            ->method('exists')
            ->with($ids[0])
            ->willReturn(false);
        
        $this->expectException(NodeUnknown::class);
        
        $graphStore->commonNodes($ids);
    }
    
    public function testItExchangesNodes()
    {
        $graphStore = new GraphStore($this->nodeStore, $this->valueStore, $this->logger);
        
        $id = 5;
        $oldId = 8;
        $newId = 43097;
        
        $this->nodeStore->expects($this->exactly(3))
            ->method('exists')
            ->withConsecutive([$id], [$oldId], [$newId])
            ->will($this->onConsecutiveCalls(true, true, true));
        
        $this->nodeStore->expects($this->once())
            ->method('contains')
            ->with($id, $oldId)
            ->willReturn(true);
        
        $graphStore->exchangeNodes($id, $oldId, $newId);
    }
    
    public function testItChecksIfNodeExistsBeforeExchangingSubnodes()
    {
        $graphStore = new GraphStore($this->nodeStore, $this->valueStore, $this->logger);
        
        $id = 5;
        $oldId = 8;
        $newId = 43097;
        
        $this->nodeStore->expects($this->at(0))
            ->method('exists')
            ->with($id)
            ->willReturn(false);
        
        $this->expectException(NodeUnknown::class);
        
        $graphStore->exchangeNodes($id, $oldId, $newId);
    }
    
    public function testItChecksIfOldNodeExistsBeforeExchanging()
    {
        $graphStore = new GraphStore($this->nodeStore, $this->valueStore, $this->logger);
        
        $id = 5;
        $oldId = 8;
        $newId = 43097;
        
        $this->nodeStore->expects($this->at(0))
            ->method('exists')
            ->with($id)
            ->willReturn(true);
        
        $this->nodeStore->expects($this->at(1))
            ->method('exists')
            ->with($oldId)
            ->willReturn(false);
        
        $this->expectException(NodeUnknown::class);
        
        $graphStore->exchangeNodes($id, $oldId, $newId);
    }
    
    public function testItChecksIfNewNodeExistsBeforeExchanging()
    {
        $graphStore = new GraphStore($this->nodeStore, $this->valueStore, $this->logger);
        
        $id = 5;
        $oldId = 8;
        $newId = 43097;
        
        $this->nodeStore->expects($this->at(0))
            ->method('exists')
            ->with($id)
            ->willReturn(true);
        
        $this->nodeStore->expects($this->at(1))
            ->method('exists')
            ->with($oldId)
            ->willReturn(true);
        
        $this->nodeStore->expects($this->at(2))
            ->method('exists')
            ->with($newId)
            ->willReturn(false);
        
        $this->expectException(NodeUnknown::class);
        
        $graphStore->exchangeNodes($id, $oldId, $newId);
    }
    
    public function testItExchangesOnlyContainedSubnode()
    {
        $graphStore = new GraphStore($this->nodeStore, $this->valueStore, $this->logger);
        
        $id = 5;
        $oldId = 8;
        $newId = 43097;
        
        $this->nodeStore->expects($this->at(0))
            ->method('exists')
            ->with($id)
            ->willReturn(true);
        
        $this->nodeStore->expects($this->at(1))
            ->method('exists')
            ->with($oldId)
            ->willReturn(true);
        
        $this->nodeStore->expects($this->at(2))
            ->method('exists')
            ->with($newId)
            ->willReturn(true);
        
        $this->nodeStore->expects($this->once())
            ->method('contains')
            ->with($id, $oldId)
            ->willReturn(false);
        
        $this->expectException(NodeExchangesNodeItContains::class);
        
        $graphStore->exchangeNodes($id, $oldId, $newId);
    }
}