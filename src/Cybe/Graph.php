<?php

namespace MemMemov\Cybe;

interface Graph
{
    public function readOrCreateNode(string $type, array $nodes): GraphNode;
    public function readOrCreateSequence(string $type, array $nodes): GraphSequence;
    public function readOrCreateValue(string $type, string $content): GraphValue;
}