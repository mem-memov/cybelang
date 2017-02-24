<?php

namespace MemMemov\Cybe\Parser;

interface Predicate
{
    /**
     * @return string[]
     */
    public function words(): array;
}