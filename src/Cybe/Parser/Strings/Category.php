<?php

namespace MemMemov\Cybe\Parser\Strings;

use MemMemov\Cybe\Parser\ICategory;

class Category implements ICategory
{
    private $string;

    public function __construct(string $string)
    {
        $this->string = $string;
    }
}