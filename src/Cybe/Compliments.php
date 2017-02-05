<?php

namespace MemMemov\Cybe;

class Compliments
{
    public function fromText(Parser\Compliment $complimentText): Compliment
    {
        return new Compliment();
    }
}