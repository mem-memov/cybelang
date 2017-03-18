<?php

namespace MemMemov\Cybelang\Cybe\Parser;

interface Clause
{
    public function text(): string;
    
    public function predicate(): Predicate;

    public function subject(): Subject;

    public function arguments(): array;
}