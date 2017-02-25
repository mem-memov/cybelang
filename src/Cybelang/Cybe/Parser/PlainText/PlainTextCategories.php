<?php

namespace MemMemov\Cybelang\Cybe\Parser\PlainText;

use MemMemov\Cybelang\Cybe\Parser\Category;

class PlainTextCategories
{
    public function create(string $string): Category
    {
        return new PlainTextCategory($string);
    }
}