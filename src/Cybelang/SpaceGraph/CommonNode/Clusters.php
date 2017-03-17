<?php

namespace MemMemov\Cybelang\SpaceGraph\CommonNode;

use MemMemov\Cybelang\SpaceGraph\Spaces;

class Clusters
{
    private $spaces;

    public function __construct(
        Spaces $spaces
    ) {
        $this->spaces = $spaces;
    }

    /**
     * @param Node[] $nodes
     * @return ClusterSet
     */
    public function createClusterSet(array $nodes): ClusterSet
    {
        $uniqueSpaces = $this->spaces->uniqueSpacesOfNodes($nodes);

        $clusters = [];
        /** @var Space $uniqueSpace */
        foreach ($uniqueSpaces as $uniqueSpace) {
            $clusterNodes = $uniqueSpace->filter($nodes);
            $clusterNodeIds = [];
            foreach ($clusterNodes as $clusterNode) {
                $clusterNodeIds[] = $clusterNode->id();
            }
            $clusters[] = new Cluster($uniqueSpace->id(), $clusterNodeIds);
        }

        if (0 === count($clusters)) {
            throw new ForbidEmptyClusterSet();
        }

        return new ClusterSet($clusters);
    }
}