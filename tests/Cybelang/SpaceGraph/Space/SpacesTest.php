<?php

namespace MemMemov\Cybelang\SpaceGraph\Space;

use MemMemov\Cybelang\SpaceGraph\Node\{Node, Nodes};
use PHPUnit\Framework\TestCase;

class SpacesTest extends TestCase
{
    /** @var Nodes|\PHPUnit_Framework_MockObject_MockObject */
    protected $nodes;
    /** @var SpaceCache|\PHPUnit_Framework_MockObject_MockObject */
    protected $spaceCache;
    /** @var SpaceRoot|\PHPUnit_Framework_MockObject_MockObject */
    protected $spaceRoot;

    protected function setUp()
    {
        $this->nodes = $this->createMock(Nodes::class);
        $this->spaceCache = $this->createMock(SpaceCache::class);
        $this->spaceRoot = $this->createMock(SpaceRoot::class);
    }

    public function testItReadsSpaceFromCache()
    {
        $spaces = new Spaces($this->nodes, $this->spaceCache, $this->spaceRoot);

        $spaceName = 'clause';

        $this->spaceCache->expects($this->once())
            ->method('hasSpaceWithName')
            ->with($spaceName)
            ->willReturn(true);

        $space = $this->createMock(Space::class);

        $this->spaceCache->expects($this->once())
            ->method('getSpaceWithName')
            ->with($spaceName)
            ->willReturn($space);

        $result = $spaces->provideSpace($spaceName);

        $this->assertSame($space, $result);
    }

    public function testItCreatesNewSpaceAndReadsItFromCache()
    {
        $spaces = new Spaces($this->nodes, $this->spaceCache, $this->spaceRoot);

        $spaceName = 'clause';

        $this->spaceCache->expects($this->exactly(2))
            ->method('hasSpaceWithName')
            ->withConsecutive([$spaceName], [$spaceName])
            ->will($this->onConsecutiveCalls(false, false));

        $this->spaceRoot->expects($this->once())
            ->method('loadSpacesIntoCache')
            ->with($this->spaceCache, $this->nodes);

        $this->spaceRoot->expects($this->once())
            ->method('addNewSpace')
            ->with($this->spaceCache, $this->nodes, $spaceName);

        $space = $this->createMock(Space::class);

        $this->spaceCache->expects($this->once())
            ->method('getSpaceWithName')
            ->with($spaceName)
            ->willReturn($space);

        $result = $spaces->provideSpace($spaceName);

        $this->assertSame($space, $result);
    }

    public function testItFillsCacheAndReadsSpaceFromIt()
    {
        $spaces = new Spaces($this->nodes, $this->spaceCache, $this->spaceRoot);

        $spaceName = 'clause';

        $this->spaceCache->expects($this->exactly(2))
            ->method('hasSpaceWithName')
            ->withConsecutive([$spaceName], [$spaceName])
            ->will($this->onConsecutiveCalls(false, true));

        $this->spaceRoot->expects($this->once())
            ->method('loadSpacesIntoCache')
            ->with($this->spaceCache, $this->nodes);

        $space = $this->createMock(Space::class);

        $this->spaceCache->expects($this->once())
            ->method('getSpaceWithName')
            ->with($spaceName)
            ->willReturn($space);

        $result = $spaces->provideSpace($spaceName);

        $this->assertSame($space, $result);
    }
    
    public function testItProvidesSpaceOfNode()
    {
        $spaces = new Spaces($this->nodes, $this->spaceCache, $this->spaceRoot);

        $node = $this->createMock(Node::class);

        $this->spaceCache->expects($this->once())
            ->method('isEmpty')
            ->willReturn(false);

        $space = $this->createMock(Space::class);

        $this->spaceCache->expects($this->once())
            ->method('getAll')
            ->willReturn([$space]);

        $space->expects($this->once())
            ->method('has')
            ->with($node)
            ->willReturn(true);
        
        $result = $spaces->spaceOfNode($node);

        $this->assertSame($space, $result);
    }

    public function testItLoadsSpacesIntoEmptyCacheBeforeProvidingSpaceOfNode()
    {
        $spaces = new Spaces($this->nodes, $this->spaceCache, $this->spaceRoot);

        $node = $this->createMock(Node::class);

        $this->spaceCache->expects($this->once())
            ->method('isEmpty')
            ->willReturn(true);

        $this->spaceRoot->expects($this->once())
            ->method('loadSpacesIntoCache')
            ->with($this->spaceCache, $this->nodes);

        $space = $this->createMock(Space::class);

        $this->spaceCache->expects($this->once())
            ->method('getAll')
            ->willReturn([$space]);

        $space->expects($this->once())
            ->method('has')
            ->with($node)
            ->willReturn(true);

        $spaces->spaceOfNode($node);
    }

    public function testItForbidsNodeInNoSpaceWhenProvidingSpaceOfNode()
    {
        $spaces = new Spaces($this->nodes, $this->spaceCache, $this->spaceRoot);

        $node = $this->createMock(Node::class);

        $this->spaceCache->expects($this->once())
            ->method('isEmpty')
            ->willReturn(false);

        $this->spaceCache->expects($this->once())
            ->method('getAll')
            ->willReturn([]);

        $this->expectException(ForbidNodeInNoSpace::class);

        $spaces->spaceOfNode($node);
    }

    public function testItForbidsOneNodeInManySpacesWhenProvidingSpaceOfNode()
    {
        $spaces = new Spaces($this->nodes, $this->spaceCache, $this->spaceRoot);

        $node = $this->createMock(Node::class);

        $this->spaceCache->expects($this->once())
            ->method('isEmpty')
            ->willReturn(false);

        $space_1 = $this->createMock(Space::class);
        $space_2 = $this->createMock(Space::class);

        $this->spaceCache->expects($this->once())
            ->method('getAll')
            ->willReturn([$space_1, $space_2]);

        $space_1->expects($this->once())
            ->method('has')
            ->with($node)
            ->willReturn(true);

        $space_2->expects($this->once())
            ->method('has')
            ->with($node)
            ->willReturn(true);

        $this->expectException(ForbidOneNodeInManySpaces::class);

        $spaces->spaceOfNode($node);
    }

    public function testItFindsUniqueSpacesOfNodes()
    {
        /** @var Spaces|\PHPUnit_Framework_MockObject_MockObject $spaces */
        $spaces = $this->getMockBuilder(Spaces::class)
            ->setConstructorArgs([$this->nodes, $this->spaceCache, $this->spaceRoot])
            ->setMethods(['spaceOfNode'])
            ->getMock();

        $node_1 = $this->createMock(Node::class);
        $node_2 = $this->createMock(Node::class);

        $this->spaceRoot->expects($this->exactly(2))
            ->method('isSpaceNode')
            ->withConsecutive([$node_1], [$node_2])
            ->will($this->onConsecutiveCalls(false, false));
        
        $space = $this->createMock(Space::class);

        $spaces->expects($this->exactly(2))
            ->method('spaceOfNode')
            ->withConsecutive([$node_1], [$node_2])
            ->will($this->onConsecutiveCalls($space, $space));
        
        $space->expects($this->exactly(2))
            ->method('id')
            ->willReturn(7);

        $result = $spaces->uniqueSpacesOfNodes([$node_1, $node_2]);

        $this->assertSame([$space], $result);
    }
    
    public function testItSkipsSpaceNodesWhenFindingUniqueSpacesOfNodes()
    {
        /** @var Spaces|\PHPUnit_Framework_MockObject_MockObject $spaces */
        $spaces = $this->getMockBuilder(Spaces::class)
            ->setConstructorArgs([$this->nodes, $this->spaceCache, $this->spaceRoot])
            ->setMethods(['spaceOfNode'])
            ->getMock();

        $node = $this->createMock(Node::class);

        $this->spaceRoot->expects($this->once())
            ->method('isSpaceNode')
            ->withConsecutive($node)
            ->willReturn(true);

        $spaces->expects($this->never())
            ->method('spaceOfNode');

        $result = $spaces->uniqueSpacesOfNodes([$node]);

        $this->assertSame([], $result);
    }

    public function testItChecksIfAllNodesAreInSameSpace()
    {
        /** @var Spaces|\PHPUnit_Framework_MockObject_MockObject $spaces */
        $spaces = $this->getMockBuilder(Spaces::class)
            ->setConstructorArgs([$this->nodes, $this->spaceCache, $this->spaceRoot])
            ->setMethods(['uniqueSpacesOfNodes'])
            ->getMock();

        $node_1 = $this->createMock(Node::class);
        $node_2 = $this->createMock(Node::class);

        $space = $this->createMock(Space::class);

        $spaces->expects($this->once())
            ->method('uniqueSpacesOfNodes')
            ->with([$node_1, $node_2])
            ->willReturn([$space]);

        $result = $spaces->inSameSpace([$node_1, $node_2]);

        $this->assertTrue($result);
    }

    public function testItChecksIfNotAllNodesAreInSameSpace()
    {
        /** @var Spaces|\PHPUnit_Framework_MockObject_MockObject $spaces */
        $spaces = $this->getMockBuilder(Spaces::class)
            ->setConstructorArgs([$this->nodes, $this->spaceCache, $this->spaceRoot])
            ->setMethods(['uniqueSpacesOfNodes'])
            ->getMock();

        $node_1 = $this->createMock(Node::class);
        $node_2 = $this->createMock(Node::class);

        $space_1 = $this->createMock(Space::class);
        $space_2 = $this->createMock(Space::class);

        $spaces->expects($this->once())
            ->method('uniqueSpacesOfNodes')
            ->with([$node_1, $node_2])
            ->willReturn([$space_1, $space_2]);

        $result = $spaces->inSameSpace([$node_1, $node_2]);

        $this->assertFalse($result);
    }
}