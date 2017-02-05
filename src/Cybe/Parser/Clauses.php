<?php

namespace MemMemov\Cybe\Parser;

interface Clauses
{
    public function create(string $string): Clause;
}