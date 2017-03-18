<?php

namespace MemMemov\Cybelang\Cybe\Parser;

interface Category
{
    public function text(): string;
    
    /**
     * @return string[]
     */
    public function words(): array;
}