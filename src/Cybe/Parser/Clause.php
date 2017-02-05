<?php

namespace MemMemov\Cybe\Parser;

interface Clause
{
    public function predicate(): Predicate;

    public function subject(): Subject;

    public function arguments(): array;
}