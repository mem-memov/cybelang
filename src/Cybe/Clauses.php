<?php

namespace MemMemov\Cybe;

class Clauses
{
    private $predicates;
    private $subjects;
    private $arguments;

    public function __construct(
        Predicates $predicates,
        Subjects $subjects,
        Arguments $arguments
    ) {
        $this->predicates = $predicates;
        $this->subjects = $subjects;
        $this->arguments = $arguments;
    }

    public function fromText(Parser\Clause $clauseText): Clause
    {
        $predicate = $this->predicates->fromText($clauseText->predicate());
        $subject = $this->subjects->fromText($clauseText->subject());

        $arguments = [];
        foreach ($clauseText->arguments() as $argumentText) {
            $arguments[] = $this->arguments->fromText($argumentText);
        }

        return new Clause(
            $predicate,
            $subject,
            $arguments
        );
    }
}