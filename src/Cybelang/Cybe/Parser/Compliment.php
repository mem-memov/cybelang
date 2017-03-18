<?php

namespace MemMemov\Cybelang\Cybe\Parser;

interface Compliment
{
    public function text(): string;
    
    /**
     * @return string[]
     */
    public function words(): array;
}