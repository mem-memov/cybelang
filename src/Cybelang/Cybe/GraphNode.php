<?php

namespace MemMemov\Cybelang\Cybe;

interface GraphNode
{
    public function id(): int;

    public function one(string $type): GraphNode;

    /**
     * @param string $type
     * @return SpaceNode[]
     */
    public function all(string $type): array;
}