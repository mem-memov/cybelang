<?php

namespace MemMemov\Cybe;

class Arguments
{
    public function fromText(Parser\Argument $argumentText): Argument
    {
        return new Argument();
    }
}