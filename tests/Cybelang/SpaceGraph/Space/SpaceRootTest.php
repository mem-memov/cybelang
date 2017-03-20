<?php

namespace MemMemov\Cybelang\SpaceGraph\Space;

use MemMemov\Cybelang\SpaceGraph\Node\{Node, Nodes};
use PHPUnit\Framework\TestCase;

class SpaceRootTest extends TestCase
{
    /** @var string */
    protected $rootName;

    protected function setUp()
    {
        $this->rootName = 'agjhweFFthg573ty_4pth';
    }

    public function testItLoadsSpacesIntoCache()
    {
        $spaceRoot = new SpaceRoot($this->rootName);

        $spaceCache = $this->createMock(SpaceCache::class);
        $nodes = $this->createMock(Nodes::class);

        $rootNode = $this->createMock(Node::class);

        $nodes->expects($this->once())
            ->method('nodeForValue')
            ->with($this->rootName)
            ->willReturn($rootNode);

        $spaceNode = $this->createMock(Node::class);

        $rootNode->expects($this->once())
            ->method('all')
            ->willReturn([$spaceNode]);
        
        $spaceNodeId = 7654321;
        
        $spaceNode->expects($this->once())
            ->method('id')
            ->willReturn($spaceNodeId);
        
        $spaceCache->expects($this->at(0))
            ->method('hasSpaceWithId')
            ->with($spaceNodeId)
            ->willReturn(false);

        $spaceName = 'clause';

        $nodes->expects($this->once())
            ->method('valueForNode')
            ->with($spaceNode)
            ->willReturn($spaceName);

        $spaceCache->expects($this->at(1))
            ->method('set')
            ->with($this->isInstanceOf(Space::class));

        $spaceRoot->loadSpacesIntoCache($spaceCache, $nodes);
    }
    
    public function tesiItSkipsNodesThatAreAlreadyInCacheWhenLoadingSpacesIntoCache()
    {
        $spaceRoot = new SpaceRoot($this->rootName);

        $spaceCache = $this->createMock(SpaceCache::class);
        $nodes = $this->createMock(Nodes::class);

        $rootNode = $this->createMock(Node::class);

        $nodes->expects($this->once())
            ->method('nodeForValue')
            ->with($this->rootName)
            ->willReturn($rootNode);

        $spaceNode = $this->createMock(Node::class);

        $rootNode->expects($this->once())
            ->method('all')
            ->willReturn([$spaceNode]);
        
        $spaceNodeId = 7654321;
        
        $spaceNode->expects($this->once())
            ->method('id')
            ->willReturn($spaceNodeId);
        
        $spaceCache->expects($this->at(0))
            ->method('hasSpaceWithId')
            ->with($spaceNodeId)
            ->willReturn(true);
        
        $spaceCache->expects($this->never())
            ->method('set');
        
        $spaceRoot->loadSpacesIntoCache($spaceCache, $nodes);
    }

    public function testItAddsNewSpace()
    {
        $spaceRoot = new SpaceRoot($this->rootName);

        $nodes = $this->createMock(Nodes::class);

        $rootNode = $this->createMock(Node::class);
        $spaceNode = $this->createMock(Node::class);

        $spaceName = 'clause';

        $nodes->expects($this->exactly(2))
            ->method('nodeForValue')
            ->withConsecutive([$spaceName], [$this->rootName])
            ->will($this->onConsecutiveCalls($spaceNode, $rootNode));

        $rootNode->expects($this->once())
            ->method('add')
            ->with($spaceNode);

        $spaceCache = $this->createMock(SpaceCache::class);

        $spaceCache->expects($this->once())
            ->method('set')
            ->with($this->isInstanceOf(Space::class));

        $spaceRoot->addNewSpace($spaceCache, $nodes, $spaceName);
    }
    
    public function testItChecksIfANodeIsASpaceOfThisRoot()
    {
        $spaceRoot = new SpaceRoot($this->rootName);
        
        $node = $this->createMock(Node::class);
        $nodes = $this->createMock(Nodes::class);

        $rootNode = $this->createMock(Node::class);
        
        $nodes->expects($this->once())
            ->method('nodeForValue')
            ->with($this->rootName)
            ->willReturn($rootNode);
        
        $rootNode->expects($this->once())
            ->method('has')
            ->with($node)
            ->willReturn(true);
        
        $result = $spaceRoot->isSpaceNode($node, $nodes);
        
        $this->assertTrue($result);
    }
    
    public function testItChecksIfANodeIsNotASpaceOfThisRoot()
    {
        $spaceRoot = new SpaceRoot($this->rootName);
        
        $node = $this->createMock(Node::class);
        $nodes = $this->createMock(Nodes::class);

        $rootNode = $this->createMock(Node::class);
        
        $nodes->expects($this->once())
            ->method('nodeForValue')
            ->with($this->rootName)
            ->willReturn($rootNode);
        
        $rootNode->expects($this->once())
            ->method('has')
            ->with($node)
            ->willReturn(false);
        
        $result = $spaceRoot->isSpaceNode($node, $nodes);
        
        $this->assertFalse($result);
    }
}