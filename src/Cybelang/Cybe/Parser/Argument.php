<?php

namespace MemMemov\Cybelang\Cybe\Parser;

interface Argument
{
    
    public function text(): string;
    
    public function category(): Category;

    public function compliment(): Compliment;
}