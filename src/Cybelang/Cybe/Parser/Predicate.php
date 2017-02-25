<?php

namespace MemMemov\Cybelang\Cybe\Parser;

interface Predicate
{
    /**
     * @return string[]
     */
    public function words(): array;
}