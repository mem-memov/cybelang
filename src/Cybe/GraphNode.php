<?php

namespace MemMemov\Cybe;

interface GraphNode
{
    public function id(): int;

    public function oneOfType(string $type): GraphNode;
    public function allOfType(string $type): array;
}