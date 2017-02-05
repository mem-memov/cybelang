<?php

namespace MemMemov\Cybe\Parser;

interface IArgument
{
    public function category(): ICategory;

    public function compliment(): ICompliment;
}