<?php

namespace MemMemov\Cybe\Parser;

interface Message
{
    public function clauses(): array;
}