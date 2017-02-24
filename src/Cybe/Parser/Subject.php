<?php

namespace MemMemov\Cybe\Parser;

interface Subject
{
    /**
     * @return string[]
     */
    public function words(): array;
}