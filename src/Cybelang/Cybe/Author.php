<?php

namespace MemMemov\Cybelang\Cybe;

class Author
{
    private $id;
    private $utterances;
    private $parser;

    public function __construct(
        int $id,
        Utterances $utterances,
        Parser\Messages $parser
    ) {
        $this->id = $id;
        $this->utterances = $utterances;
        $this->parser = $parser;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function write(string $text): int
    {
        $messageText = $this->parser->create($text);

        $utterance = $this->utterances->fromText($messageText, $this);
        
        return $utterance->id();
    }
    
    public function writeInContext(string $text, array $utteranceIds)
    {
        $messageText = $this->parser->create($text);

        $utterance = $this->utterances->fromTextInContext($messageText, $this, $utteranceIds);
        
        return $utterance->id();
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
