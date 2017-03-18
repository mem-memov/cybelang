<?php

namespace MemMemov\Cybelang\GraphStore;

use MemMemov\Cybelang\GraphStore\ValueStore\ArrayValueStore;
use MemMemov\Cybelang\GraphStore\ValueStore\Hash;
use MemMemov\Cybelang\GraphStore\NodeStore\ArrayNodeStore;
use Psr\Log\LoggerInterface;

class GraphStores
{
    public function arrayStore(string $nodePath, string $keyPath, string $valuePath, LoggerInterface $logger): GraphStore
    {
        $nodeStore = new ArrayNodeStore($nodePath);
        
        $hash = new Hash();
        $valueStore = new ArrayValueStore($hash, $keyPath, $valuePath);

        return new GraphStore($nodeStore, $valueStore, $logger);
    }
}
