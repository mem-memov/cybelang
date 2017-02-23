<?php

namespace MemMemov\Cybe;

interface Graph
{
    public function provideCommonNode(string $type, array $ids): GraphNode;

    public function provideValueNode(string $type, string $value): GraphNode;
    
    public function readNode(int $id): GraphNode;
}