<?php

namespace MemMemov\Cybelang\Cybe\Parser;

interface Message
{
    public function text(): string;
    
    public function clauses(): array;
}