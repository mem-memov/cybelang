<?php

namespace MemMemov\Cybe;

interface GraphNode
{
    public function id(): int;
    public function one(string $space): GraphNode;
    public function all(string $space, callable $use): void;
}