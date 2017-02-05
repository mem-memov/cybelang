<?php

namespace MemMemov\Cybe;

class Categories
{
    public function fromText(Parser\Category $categoryText): Category
    {
        return new Category();
    }
}