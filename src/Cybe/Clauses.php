<?php

namespace MemMemov\Cybe;

class Clauses
{
    private $parser;
    private $predicates;
    private $subjects;
    private $arguments;

    public function __construct(
        Parser\Clauses $parser,
        Predicates $predicates,
        Subjects $subjects,
        Arguments $arguments
    ) {
        $this->parser = $parser;
        $this->predicates = $predicates;
        $this->subjects = $subjects;
        $this->arguments = $arguments;
    }

    public function fromText(MessageText $messageText): array
    {
        $this->parser->create($messageText);

        $clauses = [];
        foreach ($clauseStrings as $clauseString) {
            $clauses[] = new Clause();
        }

        return $clauses;
    }
}