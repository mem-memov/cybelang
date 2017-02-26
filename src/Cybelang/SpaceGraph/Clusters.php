<?php

namespace MemMemov\Cybelang\SpaceGraph;

class Clusters
{
    private $nodes;
    private $spaces;

    public function __construct(
        Nodes $nodes,
        Spaces $spaces
    ) {
        $this->nodes = $nodes;
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

        return new ClusterSet($clusters);
    }
}