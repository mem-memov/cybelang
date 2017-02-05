<?php

namespace MemMemov\Cybe\Parser;

interface Messages
{
    public function create(string $string): Message;
}