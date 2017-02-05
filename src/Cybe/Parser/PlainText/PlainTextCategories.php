<?php

namespace MemMemov\Cybe\Parser\PlainText;

use MemMemov\Cybe\Parser\Category;

class PlainTextCategories
{
    public function create(string $string): Category
    {
        return new PlainTextCategory($string);
    }
}