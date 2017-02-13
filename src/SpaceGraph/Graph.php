<?php

namespace MemMemov\SpaceGraph;

interface Graph
{
    public function createNode(): Node;

    public function readNode(int $id): Node;

    public function createValue(string $contents): Value;

    public function readValueByNode(Node $node): Value;

    public function readValueByContents(string $contents): Value;
}