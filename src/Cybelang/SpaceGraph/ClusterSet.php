<?php

namespace MemMemov\Cybelang\SpaceGraph;

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
        if (!array_key_exists($cluster->spaceId(), $this->clusters)) {
            return false;
        }

        return $cluster->equals($this->clusters[$cluster->spaceId()]);
    }
}