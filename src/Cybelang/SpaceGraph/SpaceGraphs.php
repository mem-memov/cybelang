<?php

namespace MemMemov\Cybelang\SpaceGraph;

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
        
        $spaceNodes = new SpaceNodes($nodes, $spaces, $commonNodes, $sequences);
        
        return new SpaceGraph($spaceNodes);
    }
}
