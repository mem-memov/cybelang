<?php

namespace MemMemov\SpaceGraph;

interface Node
{
    public function id(): int;

    public function addNode(Node $node);

    public function has(Node $node): bool;

    /**
     * @return Node[]
     */
    public function nodes(): array;
}