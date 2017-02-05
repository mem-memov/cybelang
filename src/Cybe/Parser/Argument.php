<?php

namespace MemMemov\Cybe\Parser;

interface Argument
{
    public function category(): Category;

    public function compliment(): Compliment;
}