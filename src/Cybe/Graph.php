<?php

namespace MemMemov\Cybe;

interface Graph
{
    public function сreateNode(string $type, array $ids): GraphNode;
    public function readNode(int $id): GraphNode;

    public function сreateSequence(string $type, array $ids): GraphSequence;
    public function readSequence(int $id): GraphSequence;

    public function сreateValue(string $type, string $content): GraphValue;
    public function readValue(int $id): GraphValue;
}