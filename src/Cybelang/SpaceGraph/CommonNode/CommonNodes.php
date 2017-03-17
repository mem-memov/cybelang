<?php

namespace MemMemov\Cybelang\SpaceGraph\CommonNode;

use MemMemov\Cybelang\SpaceGraph\Nodes;
use MemMemov\Cybelang\SpaceGraph\Space;

class CommonNodes
{
    private $nodes;
    private $clusters;

    public function __construct(
        Nodes $nodes,
        Clusters $clusters
    ) {
        $this->nodes = $nodes;
        $this->clusters = $clusters;
    }

    /**
     * @param Space $space
     * @param array $ids
     * @return Node[]
     */
    public function provideMatchingCommonNodes(Space $space, array $ids): array
    {
        $nodes = $this->nodes->readMany($ids);

        $masterClusterSet = $this->clusters->createClusterSet($nodes);

        $commonNodes = $space->filter(
            $this->nodes->commonNodes($ids)
        );

        $matchingCommonNodes = [];
        foreach ($commonNodes as $commonNode) {
            $clusterSet = $this->clusters->createClusterSet($commonNode->all());
            if ($masterClusterSet->inClusterSet($clusterSet)) {
                $matchingCommonNodes[] = $commonNode;
            }
        }

        return $matchingCommonNodes;
    }
}