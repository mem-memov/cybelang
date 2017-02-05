<?php

namespace MemMemov\Cybe\Parser;

interface IMessages
{
    public function create(string $string): IMessage;
}