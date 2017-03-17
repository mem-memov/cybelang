<?php

namespace MemMemov\Cybelang\SpaceGraph\Space;

use PHPUnit\Framework\TestCase;

class SpaceCacheTest extends TestCase
{
    public function testItSetsSpace()
    {
        /** @var SpaceCache|\PHPUnit_Framework_MockObject_MockObject $spaceCache */
        $spaceCache = $this->getMockBuilder(SpaceCache::class)
            ->setMethods(['hasSpaceWithId', 'hasSpaceWithName'])
            ->getMock();

        $spaceId = 5;
        $spaceName = 'clause';

        $space = $this->createMock(Space::class);

        $space->expects($this->once())
            ->method('name')
            ->willReturn($spaceName);

        $space->expects($this->once())
            ->method('id')
            ->willReturn($spaceId);

        $spaceCache->expects($this->once())
            ->method('hasSpaceWithId')
            ->with($spaceId)
            ->willReturn(false);

        $spaceCache->expects($this->once())
            ->method('hasSpaceWithName')
            ->with($spaceName)
            ->willReturn(false);

        $spaceCache->set($space);
    }

    public function testItForbidsNonUniqueSpaceInstancesWithSameId()
    {
        /** @var SpaceCache|\PHPUnit_Framework_MockObject_MockObject $spaceCache */
        $spaceCache = $this->getMockBuilder(SpaceCache::class)
            ->setMethods(['hasSpaceWithId', 'getSpaceWithId'])
            ->getMock();

        $spaceId = 5;
        $spaceName = 'clause';

        $space = $this->createMock(Space::class);

        $space->expects($this->once())
            ->method('name')
            ->willReturn($spaceName);

        $space->expects($this->once())
            ->method('id')
            ->willReturn($spaceId);

        $spaceCache->expects($this->once())
            ->method('hasSpaceWithId')
            ->with($spaceId)
            ->willReturn(true);

        $duplicateSpace = $this->createMock(Space::class);

        $spaceCache->expects($this->once())
            ->method('getSpaceWithId')
            ->with($spaceId)
            ->willReturn($duplicateSpace);

        $this->expectException(ForbidNonUniqueInstancesInCache::class);

        $spaceCache->set($space);
    }

    public function testItForbidsNonUniqueSpaceInstancesWithSameName()
    {
        /** @var SpaceCache|\PHPUnit_Framework_MockObject_MockObject $spaceCache */
        $spaceCache = $this->getMockBuilder(SpaceCache::class)
            ->setMethods(['hasSpaceWithId', 'hasSpaceWithName', 'getSpaceWithName'])
            ->getMock();

        $spaceId = 5;
        $spaceName = 'clause';

        $space = $this->createMock(Space::class);

        $space->expects($this->once())
            ->method('name')
            ->willReturn($spaceName);

        $space->expects($this->once())
            ->method('id')
            ->willReturn($spaceId);

        $spaceCache->expects($this->once())
            ->method('hasSpaceWithId')
            ->with($spaceId)
            ->willReturn(false); // just skipping the check

        $spaceCache->expects($this->once())
            ->method('hasSpaceWithName')
            ->with($spaceName)
            ->willReturn(true);

        $duplicateSpace = $this->createMock(Space::class);

        $spaceCache->expects($this->once())
            ->method('getSpaceWithName')
            ->with($spaceName)
            ->willReturn($duplicateSpace);

        $this->expectException(ForbidNonUniqueInstancesInCache::class);

        $spaceCache->set($space);
    }

    public function testItChecksItContainsASpaceWithACertainName()
    {
        $spaceCache = new SpaceCache();

        $spaceId = 5;
        $spaceName = 'clause';

        $space = $this->createMock(Space::class);

        $space->expects($this->once())
            ->method('name')
            ->willReturn($spaceName);

        $space->expects($this->once())
            ->method('id')
            ->willReturn($spaceId);

        $spaceCache->set($space);

        $result = $spaceCache->hasSpaceWithName($spaceName);

        $this->assertTrue($result);
    }

    public function testItChecksItDoesNotContainASpaceWithACertainName()
    {
        $spaceCache = new SpaceCache();

        $spaceName = 'clause';

        $result = $spaceCache->hasSpaceWithName($spaceName);

        $this->assertFalse($result);
    }

    public function testItChecksItContainsASpaceWithACertainId()
    {
        $spaceCache = new SpaceCache();

        $spaceId = 5;
        $spaceName = 'clause';

        $space = $this->createMock(Space::class);

        $space->expects($this->once())
            ->method('name')
            ->willReturn($spaceName);

        $space->expects($this->once())
            ->method('id')
            ->willReturn($spaceId);

        $spaceCache->set($space);

        $result = $spaceCache->hasSpaceWithId($spaceId);

        $this->assertTrue($result);
    }

    public function testItChecksItDoesNotContainASpaceWithACertainId()
    {
        $spaceCache = new SpaceCache();

        $spaceId = 5;

        $result = $spaceCache->hasSpaceWithId($spaceId);

        $this->assertFalse($result);
    }

    public function testItChecksItIsEmpty()
    {
        $spaceCache = new SpaceCache();

        $result = $spaceCache->isEmpty();

        $this->assertTrue($result);
    }

    public function testItChecksItIsNotEmpty()
    {
        $spaceCache = new SpaceCache();

        $spaceId = 5;
        $spaceName = 'clause';

        $space = $this->createMock(Space::class);

        $space->expects($this->once())
            ->method('name')
            ->willReturn($spaceName);

        $space->expects($this->once())
            ->method('id')
            ->willReturn($spaceId);

        $spaceCache->set($space);

        $result = $spaceCache->isEmpty();

        $this->assertFalse($result);
    }

    public function testItSuppliesAllSpacesItContains()
    {
        $spaceCache = new SpaceCache();

        $spaceId = 5;
        $spaceName = 'clause';

        $space = $this->createMock(Space::class);

        $space->expects($this->once())
            ->method('name')
            ->willReturn($spaceName);

        $space->expects($this->once())
            ->method('id')
            ->willReturn($spaceId);

        $spaceCache->set($space);

        $result = $spaceCache->getAll();

        $this->assertSame([$space], $result);
    }

    public function testItSuppliesSpaceWithId()
    {
        /** @var SpaceCache|\PHPUnit_Framework_MockObject_MockObject $spaceCache */
        $spaceCache = $this->getMockBuilder(SpaceCache::class)
            ->setMethods(['hasSpaceWithId'])
            ->getMock();

        $spaceId = 5;
        $spaceName = 'clause';

        $space = $this->createMock(Space::class);

        $space->expects($this->once())
            ->method('name')
            ->willReturn($spaceName);

        $space->expects($this->once())
            ->method('id')
            ->willReturn($spaceId);

        $spaceCache->set($space);

        $spaceCache->expects($this->once())
            ->method('hasSpaceWithId')
            ->with($spaceId)
            ->willReturn(true);

        $result = $spaceCache->getSpaceWithId($spaceId);

        $this->assertSame($space, $result);
    }

    public function testItComplainsIfNoSpaceToSupplyById()
    {
        /** @var SpaceCache|\PHPUnit_Framework_MockObject_MockObject $spaceCache */
        $spaceCache = $this->getMockBuilder(SpaceCache::class)
            ->setMethods(['hasSpaceWithId'])
            ->getMock();

        $spaceId = 5;

        $spaceCache->expects($this->once())
            ->method('hasSpaceWithId')
            ->with($spaceId)
            ->willReturn(false);

        $this->expectException(ComplainAboutItemsMissingInCache::class);

        $spaceCache->getSpaceWithId($spaceId);
    }

    public function testItSuppliesSpaceWithName()
    {
        /** @var SpaceCache|\PHPUnit_Framework_MockObject_MockObject $spaceCache */
        $spaceCache = $this->getMockBuilder(SpaceCache::class)
            ->setMethods(['hasSpaceWithName'])
            ->getMock();

        $spaceId = 5;
        $spaceName = 'clause';

        $space = $this->createMock(Space::class);

        $space->expects($this->once())
            ->method('name')
            ->willReturn($spaceName);

        $space->expects($this->once())
            ->method('id')
            ->willReturn($spaceId);

        $spaceCache->set($space);

        $spaceCache->expects($this->once())
            ->method('hasSpaceWithName')
            ->with($spaceName)
            ->willReturn(true);

        $result = $spaceCache->getSpaceWithName($spaceName);

        $this->assertSame($space, $result);
    }

    public function testItComplainsIfNoSpaceToSupplyByName()
    {
        /** @var SpaceCache|\PHPUnit_Framework_MockObject_MockObject $spaceCache */
        $spaceCache = $this->getMockBuilder(SpaceCache::class)
            ->setMethods(['hasSpaceWithName'])
            ->getMock();

        $spaceName = 'clause';

        $spaceCache->expects($this->once())
            ->method('hasSpaceWithName')
            ->with($spaceName)
            ->willReturn(false);

        $this->expectException(ComplainAboutItemsMissingInCache::class);

        $spaceCache->getSpaceWithName($spaceName);
    }
}