<?php

namespace MemMemov\Cybe;

class Compliments
{
    public function fromText(Parser\ICompliment $complimentText): Compliment
    {
        return new Compliment();
    }
}