<?php

namespace MemMemov\Cybe\Parser;

interface IClause
{
    public function predicate(): IPredicate;

    public function subject(): ISubject;

    public function arguments(): array;
}