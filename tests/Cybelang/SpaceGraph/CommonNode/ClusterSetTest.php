<?php

namespace MemMemov\Cybelang\SpaceGraph\CommonNode;

use PHPUnit\Framework\TestCase;

class ClusterSetTest extends TestCase
{
    /** @var int */
    protected $spaceId;
    /** @var Cluster|\PHPUnit_Framework_MockObject_MockObject */
    protected $cluster;

    protected function setUp()
    {
        $this->cluster = $this->createMock(Cluster::class);

        $this->spaceId = 73;

        $this->cluster->expects($this->once())
            ->method('spaceId')
            ->willReturn($this->spaceId);
    }

    public function testItChecksIfItIsContainedInAnotherClusterSet()
    {
        $clusterSet = new ClusterSet([$this->cluster]);

        $anotherClusterSet = $this->createMock(ClusterSet::class);

        $anotherClusterSet->expects($this->once())
            ->method('hasCluster')
            ->with($this->cluster)
            ->willReturn(true);

        $result = $clusterSet->inClusterSet($anotherClusterSet);

        $this->assertTrue($result);
    }

    public function testItChecksIfItIsNotContainedInAnotherClusterSet()
    {
        $clusterSet = new ClusterSet([$this->cluster]);

        $anotherClusterSet = $this->createMock(ClusterSet::class);

        $anotherClusterSet->expects($this->once())
            ->method('hasCluster')
            ->with($this->cluster)
            ->willReturn(false);

        $result = $clusterSet->inClusterSet($anotherClusterSet);

        $this->assertFalse($result);
    }

    public function testItChecksIfItContainsACluster()
    {
        $clusterSet = new ClusterSet([$this->cluster]);

        $cluster = $this->createMock(Cluster::class);

        $cluster->expects($this->once())
            ->method('spaceId')
            ->willReturn($this->spaceId);

        $cluster->expects($this->once())
            ->method('equals')
            ->with($this->cluster)
            ->willReturn(true);

        $result = $clusterSet->hasCluster($cluster);

        $this->assertTrue($result);
    }

    public function testItChecksIfItDoesNotContainAClusterBecauseOfDifferentSpace()
    {
        $clusterSet = new ClusterSet([$this->cluster]);

        $cluster = $this->createMock(Cluster::class);

        $differentSpaceId = $this->spaceId + 100;

        $cluster->expects($this->once())
            ->method('spaceId')
            ->willReturn($differentSpaceId);

        $result = $clusterSet->hasCluster($cluster);

        $this->assertFalse($result);
    }

    public function testItChecksIfItDoesNotContainACluster()
    {
        $clusterSet = new ClusterSet([$this->cluster]);

        $cluster = $this->createMock(Cluster::class);

        $cluster->expects($this->once())
            ->method('spaceId')
            ->willReturn($this->spaceId);

        $cluster->expects($this->once())
            ->method('equals')
            ->with($this->cluster)
            ->willReturn(false);

        $result = $clusterSet->hasCluster($cluster);

        $this->assertFalse($result);
    }
}