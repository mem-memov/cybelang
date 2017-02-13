<?php

namespace MemMemov\SpaceGraph;

interface Node
{
    public function id(): int;

    public function addNode(Node $node);
}