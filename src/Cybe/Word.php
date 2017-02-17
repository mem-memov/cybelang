<?php

namespace MemMemov\Cybe;

class Word
{
    private $id;
    private $content;

    public function __construct(
        int $id,
        string $content
    ) {
        $this->id = $id;
        $this->content = $content;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function content(): string
    {
        return $this->content;
    }
}