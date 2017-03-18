<?php

namespace MemMemov\Cybelang\Cybe\Parser;

interface Predicate
{
    public function text(): string;
    
    /**
     * @return string[]
     */
    public function words(): array;
}