<?php

namespace MemMemov\Cybe\Parser\Strings;

class Categories
{
    public function create(string $string): Category
    {
        return new Category($string);
    }
}