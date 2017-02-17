<?php

namespace MemMemov\Cybe\Parser;

interface Predicate
{
    public function getWords(): array;

    public function arguments(): array;
}