<?php

namespace MemMemov\Cybelang\SpaceGraph;

use PHPUnit\Framework\TestCase;

class SpacesTest extends TestCase
{
    /** @var Nodes|\PHPUnit_Framework_MockObject_MockObject */
    protected $nodes;
    /** @var SpaceCache|\PHPUnit_Framework_MockObject_MockObject */
    protected $cache;
    /** @var SpaceRoot|\PHPUnit_Framework_MockObject_MockObject */
    protected $spaceRoot;

    protected function setUp()
    {
        $this->nodes = $this->createMock(Nodes::class);
        $this->cache = $this->createMock(SpaceCache::class);
        $this->spaceRoot = $this->createMock(SpaceRoot::class);
    }

    public function testItReadsSpaceFromCache()
    {
        $spaces = new Spaces($this->nodes, $this->cache, $this->spaceRoot);

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
        $spaces = new Spaces($this->nodes, $this->cache, $this->spaceRoot);

        $spaceName = 'clause';

        $this->cache->expects($this->exactly(2))
            ->method('hasSpaceWithName')
            ->withConsecutive([$spaceName], [$spaceName])
            ->will($this->onConsecutiveCalls(false, false));

        $this->spaceRoot->expects($this->once())
            ->method('loadSpacesIntoCache')
            ->with($this->cache, $this->nodes);

        $this->spaceRoot->expects($this->once())
            ->method('addNewSpace')
            ->with($this->cache, $this->nodes, $spaceName);

        $space = $this->createMock(Space::class);

        $this->cache->expects($this->once())
            ->method('getSpaceWithName')
            ->with($spaceName)
            ->willReturn($space);

        $result = $spaces->provideSpace($spaceName);

        $this->assertSame($space, $result);
    }

    public function testItFillsCacheAndReadsSpaceFromIt()
    {
        $spaces = new Spaces($this->nodes, $this->cache, $this->spaceRoot);

        $spaceName = 'clause';

        $this->cache->expects($this->exactly(2))
            ->method('hasSpaceWithName')
            ->withConsecutive([$spaceName], [$spaceName])
            ->will($this->onConsecutiveCalls(false, true));

        $this->spaceRoot->expects($this->once())
            ->method('loadSpacesIntoCache')
            ->with($this->cache, $this->nodes);

        $space = $this->createMock(Space::class);

        $this->cache->expects($this->once())
            ->method('getSpaceWithName')
            ->with($spaceName)
            ->willReturn($space);

        $result = $spaces->provideSpace($spaceName);

        $this->assertSame($space, $result);
    }
}