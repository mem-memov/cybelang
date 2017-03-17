<?php

namespace MemMemov\Cybelang\Cybe;

class Author
{
    private $id;
    private $messages;
    private $utterances;
    private $parser;

    public function __construct(
        int $id,
        Messages $messages,
        Utterances $utterances,
        Parser\Messages $parser
    ) {
        $this->id = $id;
        $this->messages = $messages;
        $this->utterances = $utterances;
        $this->parser = $parser;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function write(string $text)
    {
        $messageText = $this->parser->create($text);

        $message = $this->messages->fromText($messageText, $this);
        
        $this->utterances->create($message, $this);
    }
    
    public function recall(int $limit): string
    {
        $utterances = $this->utterances->ofAuthor($this, $limit);
       
        $text = '';
        foreach ($utterances as $utterance) {
            $message = $utterance->message();
            $text .= $message->toText();
        }
        
        return $text;
    }
}
