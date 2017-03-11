<?php

namespace MemMemov\Cybelang\Cybe;

class Author
{
    private $id;
    private $parser;
    private $messages;

    public function __construct(
        int $id,
        Parser\Messages $parser,
        Messages $messages
    ) {
        $this->id = $id;
        $this->parser = $parser;
        $this->messages = $messages;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function write(string $text)
    {
        $messageText = $this->parser->create($text);

        $message = $this->messages->fromText($messageText, $this);
    }
}
