<?php

namespace MemMemov\Cybelang\SpaceGraph\Space;

use MemMemov\Cybelang\SpaceGraph\Node;
use MemMemov\Cybelang\SpaceGraph\Nodes;
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

        $spaceName = 'clause';

        $nodes->expects($this->once())
            ->method('valueForNode')
            ->with($spaceNode)
            ->willReturn($spaceName);

        $spaceCache = $this->createMock(SpaceCache::class);

        $spaceCache->expects($this->once())
            ->method('set')
            ->with($this->isInstanceOf(Space::class));

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
}