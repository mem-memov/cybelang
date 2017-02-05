<?php

namespace MemMemov\Cybe;

class Categories
{
    public function fromText(Parser\ICategory $categoryText): Category
    {
        return new Category();
    }
}