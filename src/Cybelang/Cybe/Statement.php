<?php

namespace MemMemov\Cybelang\Cybe;

class Statement
{
    private $id;
    private $contexts;
    private $messages;
    
    public function __construct(
        int $id,
        Contexts $contexts,
        Messages $messages
    ) {
        $this->id = $id;
        $this->contexts = $contexts;
        $this->messages = $messages;
    }

    public function id(): int
    {
        return $this->id;
    }
}
