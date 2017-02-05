<?php

namespace MemMemov\Cybe\Parser\Strings;

use MemMemov\Cybe\Parser\ICategory;

class Categories
{
    public function create(string $string): ICategory
    {
        return new Category($string);
    }
}