<?php

namespace MemMemov\Cybe\Parser;

class Categories
{
    public function create(string $string): Category
    {
        return new Category($string);
    }
}