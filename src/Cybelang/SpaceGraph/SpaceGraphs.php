<?php

namespace MemMemov\Cybelang\SpaceGraph;

class SpaceGraphs
{
    private $store;
    private $rootName;
    
    public function __construct(
        Store $store,
        string $rootName
    ) {
        $this->store = $store;
        $this->rootName = $rootName;
    }

    public function create(): SpaceGraph
    {
        $nodeCache = new NodeCache();
        $nodes = new Nodes($this->store, $nodeCache);
        
        $spaceCache = new SpaceCache();
        $spaceRoot = new SpaceRoot($this->rootName);
        $spaces = new Spaces($nodes, $spaceCache, $spaceRoot);
        
        $clusters = new Clusters($spaces);
        $commonNodes = new CommonNodes($nodes, $clusters);
        
        $sequenceTrees = new SequenceTrees($nodes, $spaces);
        $sequences = new Sequences($nodes, $sequenceTrees);
        
        $spaceNodes = new SpaceNodes($nodes, $spaces, $commonNodes, $sequences);
        
        return new SpaceGraph($spaceNodes);
    }
}
