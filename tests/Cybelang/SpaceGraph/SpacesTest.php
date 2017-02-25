<?php

namespace MemMemov\Cybelang\SpaceGraph;

use PHPUnit\Framework\TestCase;

class SpacesTest extends TestCase
{
    /** @var Nodes|\PHPUnit_Framework_MockObject_MockObject */
    protected $nodes;
    /** @var SpaceCache|\PHPUnit_Framework_MockObject_MockObject */
    protected $cache;
    /** @var string */
    protected $rootName;

    protected function setUp()
    {
        $this->nodes = $this->createMock(Nodes::class);
        $this->cache = $this->createMock(SpaceCache::class);
        $this->rootName = 'someCrazyName34t3f@';
    }

    public function testItReadsSpaceFromCache()
    {
        $spaces = new Spaces($this->nodes, $this->cache, $this->rootName);

        $spaceName = 'clause';

        $this->cache->expects($this->once())
            ->method('hasSpaceWithName')
            ->with($spaceName)
            ->willReturn(true);

        $space = $this->createMock(Space::class);

        $this->cache->expects($this->once())
            ->method('getSpaceWithName')
            ->with($spaceName)
            ->willReturn($space);

        $result = $spaces->provideSpace($spaceName);

        $this->assertSame($space, $result);
    }

    public function testItCreatesNewSpaceAndReadsItFromCache()
    {
        $spaces = new Spaces($this->nodes, $this->cache, $this->rootName);

        $spaceName = 'clause';

        $spaceNode = $this->createMock(Node::class);

        $rootNode = $this->createMock(Node::class);
        $rootNode->expects($this->once())
            ->method('all')
            ->willReturn([]);
        $rootNode->expects($this->once())
            ->method('add')
            ->with($spaceNode);

        $this->cache->expects($this->exactly(2))
            ->method('hasSpaceWithName')
            ->withConsecutive([$spaceName], [$spaceName])
            ->will($this->onConsecutiveCalls(false, false));

        $this->nodes->expects($this->exactly(2))
            ->method('nodeForValue')
            ->withConsecutive([$this->rootName], [$spaceName])
            ->will($this->onConsecutiveCalls($rootNode, $spaceNode));

        $this->cache->expects($this->once())
            ->method('set')
            ->with($this->isInstanceOf(Space::class));

        $space = $this->createMock(Space::class);

        $this->cache->expects($this->once())
            ->method('getSpaceWithName')
            ->with($spaceName)
            ->willReturn($space);

        $result = $spaces->provideSpace($spaceName);

        $this->assertSame($space, $result);
    }

    public function testItRefreshesCacheAndReadsSpaceFromIt()
    {
        $spaces = new Spaces($this->nodes, $this->cache, $this->rootName);

        $spaceId = 3;
        $spaceName = 'clause';

        $this->cache->expects($this->exactly(2))
            ->method('hasSpaceWithName')
            ->withConsecutive([$spaceName], [$spaceName])
            ->will($this->onConsecutiveCalls(false, true));

        $spaceNode = $this->createMock(Node::class);
        $spaceNode->expects($this->once())
            ->method('id')
            ->willReturn($spaceId);

        $rootNode = $this->createMock(Node::class);
        $rootNode->expects($this->once())
            ->method('all')
            ->willReturn([$spaceNode]);

        $this->nodes->expects($this->once())
            ->method('nodeForValue')
            ->with($this->rootName)
            ->willReturn($rootNode);

        $space = $this->createMock(Space::class);

        $this->cache->expects($this->once())
            ->method('hasSpaceWithId')
            ->with($spaceId)
            ->willReturn(false);
        $this->cache->expects($this->once())
            ->method('set')
            ->with($this->isInstanceOf(Space::class));
        $this->cache->expects($this->once())
            ->method('getSpaceWithName')
            ->with($spaceName)
            ->willReturn($space);

        $result = $spaces->provideSpace($spaceName);

        $this->assertSame($space, $result);
    }
}