<?php

namespace MemMemov\Cybe;

interface SpaceGraph
{
    public function readOrCreateNode(string $type, array $nodes): GraphNode;
    public function readOrCreateValue(string $type, string $content): GraphValue;
}