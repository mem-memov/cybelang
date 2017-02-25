<?php

namespace MemMemov\Cybelang\Cybe\Parser;

interface Messages
{
    public function create(string $string): Message;
}