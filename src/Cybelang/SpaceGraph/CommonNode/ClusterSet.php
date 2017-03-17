<?php

namespace MemMemov\Cybelang\SpaceGraph\CommonNode;

class ClusterSet
{
    private  $clusters;

    /**
     * ClusterSet constructor.
     * @param Cluster[] $clusters
     */
    public function __construct(array $clusters)
    {
        $this->clusters = [];

        foreach ($clusters as $cluster) {
            $this->clusters[$cluster->spaceId()] = $cluster;
        }
    }

    public function inClusterSet(ClusterSet $clusterSet): bool
    {
        foreach ($this->clusters as $cluster) {
            if (!$clusterSet->hasCluster($cluster)) {
                return false;
            }
        }

        return true;
    }

    public function hasCluster(Cluster $cluster): bool
    {
        $clusterSpaceId = $cluster->spaceId();

        if (!array_key_exists($clusterSpaceId, $this->clusters)) {
            return false;
        }

        return $cluster->equals($this->clusters[$clusterSpaceId]);
    }
}