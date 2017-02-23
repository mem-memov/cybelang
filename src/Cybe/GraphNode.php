<?php

namespace MemMemov\Cybe;

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