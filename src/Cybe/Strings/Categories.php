<?php

namespace MemMemov\Cybe\Strings;

class Categories
{
    public function create(string $string): Category
    {
        return new Category($string);
    }
}