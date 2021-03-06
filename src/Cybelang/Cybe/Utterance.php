<?php

namespace MemMemov\Cybelang\Cybe;

class Utterance
{
    private $id;
    private $authors;
    private $messages;
    
    public function __construct(
        int $id,
        Authors $authors,
        Messages $messages
    ) {
        $this->id = $id;
        $this->authors = $authors;
        $this->messages = $messages;
    }

    public function id(): int
    {
        return $this->id;
    }
    
    public function message(): Message
    {
        return $this->messages->ofUtterance($this);
    }
}
