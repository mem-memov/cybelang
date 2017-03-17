<?php

namespace MemMemov\Cybelang\SpaceGraph;

use MemMemov\Cybelang\SpaceGraph\CommonNode\{Clusters, CommonNodes};
use MemMemov\Cybelang\SpaceGraph\Node\{NodeCache, Nodes, Store};
use MemMemov\Cybelang\SpaceGraph\Row\Rows;
use MemMemov\Cybelang\SpaceGraph\Sequence\{SequenceTrees, Sequences};
use MemMemov\Cybelang\SpaceGraph\Space\{SpaceCache, Spaces, SpaceRoot};

class SpaceGraphs
{
    public function create(Store $store, string $rootName): SpaceGraph
    {
        $nodeCache = new NodeCache();
        $nodes = new Nodes($store, $nodeCache);
        
        $spaceCache = new SpaceCache();
        $spaceRoot = new SpaceRoot($rootName);
        $spaces = new Spaces($nodes, $spaceCache, $spaceRoot);
        
        $clusters = new Clusters($spaces);
        $commonNodes = new CommonNodes($nodes, $clusters);
        
        $sequenceTrees = new SequenceTrees($nodes, $spaces);
        $sequences = new Sequences($nodes, $sequenceTrees);
        
        $rows = new Rows($nodes, $spaces);
        
        $spaceNodes = new SpaceNodes($nodes, $spaces, $commonNodes, $sequences, $rows);
        
        return new SpaceGraph($spaceNodes);
    }
}
