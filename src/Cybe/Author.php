<?php

namespace MemMemov\Cybe;

class Author
{
    private $parser;
    private $messages;

    public function __construct(
        Parser\Messages $parser,
        Messages $messages
    ) {
        $this->parser = $parser;
        $this->messages = $messages;
    }

    public function write(string $text)
    {
        $messageText = $this->parser->create($text);

        $message = $this->messages->fromText($messageText);
    }
}
