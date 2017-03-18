<?php

namespace MemMemov\Cybelang\Cybe\Parser;

interface Subject
{
    public function text(): string;
    
    /**
     * @return string[]
     */
    public function words(): array;
}