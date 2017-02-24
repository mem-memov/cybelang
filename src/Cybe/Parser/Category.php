<?php

namespace MemMemov\Cybe\Parser;

interface Category
{
    /**
     * @return string[]
     */
    public function words(): array;
}