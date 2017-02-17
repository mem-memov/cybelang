<?php

namespace MemMemov\Cybe;

interface GraphNode
{
    public function id(): int;
    public function one(string $type): GraphNode;
    public function all(string $type, callable $use): void;
}