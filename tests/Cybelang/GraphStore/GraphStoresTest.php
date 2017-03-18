<?php

namespace MemMemov\Cybelang\GraphStore;

use Psr\Log\LoggerInterface;
use org\bovigo\vfs\vfsStream;
use PHPUnit\Framework\TestCase;

class GraphStoresTest  extends TestCase
{
    public function testItCreatesArrayStore()
    {
        $graphStores = new GraphStores();
        
        vfsStream::setup('rootDirectory', null, [
            'node_store.txt' => '',
            'key_store.txt' => '',
            'value_store.txt' => ''
        ]);
        
        $nodePath = vfsStream::url('rootDirectory/node_store.txt');
        $keyPath = vfsStream::url('rootDirectory/key_store.txt');
        $valuePath = vfsStream::url('rootDirectory/value_store.txt');
        
        $logger = $this->createMock(LoggerInterface::class);
                
        $result = $graphStores->arrayStore($nodePath, $keyPath, $valuePath, $logger);
        
        $this->assertInstanceOf(GraphStore::class, $result);
    }
}
