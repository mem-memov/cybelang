<?php

namespace MemMemov\Cybelang\SpaceGraph;

use PHPUnit\Framework\TestCase;

class ClusterTest extends TestCase
{
    public function testItSuppliesSpaceId()
    {
        $spaceId = 4;
        $nodeIds = [56, 7, 104];

        $cluster = new Cluster($spaceId, $nodeIds);

        $result = $cluster->spaceId();

        $this->assertEquals($spaceId, $result);
    }

    public function testItSuppliesNodeIds()
    {
        $spaceId = 4;
        $nodeIds = [56, 7, 104];

        $cluster = new Cluster($spaceId, $nodeIds);

        $result = $cluster->nodeIds();

        $this->assertEquals($nodeIds, $result);
    }

    public function testItChecksItIsEqualToAnotherCluster()
    {
        $spaceId = 4;
        $nodeIds = [56, 7, 104];

        $cluster = new Cluster($spaceId, $nodeIds);

        $anotherCluster = $this->createMock(Cluster::class);

        $anotherCluster->expects($this->once())
            ->method('spaceId')
            ->willReturn($spaceId);

        $anotherCluster->expects($this->once())
            ->method('nodeIds')
            ->willReturn($nodeIds);

        $result = $cluster->equals($anotherCluster);

        $this->assertTrue($result);
    }

    public function testItChecksItHasDifferentSpaceComparedToAnotherCluster()
    {
        $spaceId = 4;
        $nodeIds = [56, 7, 104];

        $cluster = new Cluster($spaceId, $nodeIds);

        $anotherCluster = $this->createMock(Cluster::class);

        $anotherSpaceId = 80;

        $anotherCluster->expects($this->once())
            ->method('spaceId')
            ->willReturn($anotherSpaceId);

        $result = $cluster->equals($anotherCluster);

        $this->assertFalse($result);
    }

    public function testItChecksItHasDifferentNodesComparedToAnotherCluster()
    {
        $spaceId = 4;
        $nodeIds = [56, 7, 104];

        $cluster = new Cluster($spaceId, $nodeIds);

        $anotherCluster = $this->createMock(Cluster::class);

        $anotherCluster->expects($this->once())
            ->method('spaceId')
            ->willReturn($spaceId);

        $otherNodeIds = [1000, 2000];

        $anotherCluster->expects($this->once())
            ->method('nodeIds')
            ->willReturn($otherNodeIds);

        $result = $cluster->equals($anotherCluster);

        $this->assertFalse($result);
    }

    public function testItChecksItHasMoreNodesComparedToAnotherCluster()
    {
        $spaceId = 4;
        $nodeIds = [56, 7, 104];

        $cluster = new Cluster($spaceId, $nodeIds);

        $anotherCluster = $this->createMock(Cluster::class);

        $anotherCluster->expects($this->once())
            ->method('spaceId')
            ->willReturn($spaceId);

        $otherNodeIds = [56, 7];

        $anotherCluster->expects($this->once())
            ->method('nodeIds')
            ->willReturn($otherNodeIds);

        $result = $cluster->equals($anotherCluster);

        $this->assertFalse($result);
    }

    public function testItChecksItHasLessNodesComparedToAnotherCluster()
    {
        $spaceId = 4;
        $nodeIds = [56, 7];

        $cluster = new Cluster($spaceId, $nodeIds);

        $anotherCluster = $this->createMock(Cluster::class);

        $anotherCluster->expects($this->once())
            ->method('spaceId')
            ->willReturn($spaceId);

        $otherNodeIds = [56, 7, 104];

        $anotherCluster->expects($this->once())
            ->method('nodeIds')
            ->willReturn($otherNodeIds);

        $result = $cluster->equals($anotherCluster);

        $this->assertFalse($result);
    }

}