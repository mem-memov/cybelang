<?php

namespace MemMemov\Cybe;

interface GraphValue extends GraphNode
{
    public function content(): string;
}