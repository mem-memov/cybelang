<?php

namespace MemMemov\Cybelang\Cybe;

use Psr\Log\LoggerInterface;

class Cybes
{
    public function create(Graph $graph, Parser\Messages $parser, LoggerInterface $logger): Cybe
    {
        $words = new Words($graph, $logger);
        $phrases = new Phrases($graph, $words, $logger);
        $subjects = new Subjects($graph, $phrases, $logger);
        $categories = new Categories($graph, $phrases, $logger);
        $compliments = new Compliments($graph, $phrases, $logger);
        $arguments = new Arguments($graph, $categories, $compliments, $logger);
        $predicates = new Predicates($graph, $arguments, $phrases, $logger);
        $clauses = new Clauses($graph, $subjects, $predicates, $arguments, $logger);
        $messages = new Messages($graph, $clauses, $logger);
        $contexts = new Contexts($graph, $messages, $logger);
        $statements = new Statements($graph, $messages, $logger);
        $utterances = new Utterances($graph, $messages, $logger);
        $authors = new Authors($graph, $messages, $utterances, $parser, $logger);
        
        $words->setPhrases($phrases);
        $phrases->setSubjects($subjects);
        $phrases->setPredicates($predicates);
        $phrases->setCategories($categories);
        $phrases->setCompliments($compliments);
        $subjects->setClauses($clauses);
        $predicates->setClauses($clauses);
        $arguments->setClauses($clauses);
        $categories->setArguments($arguments);
        $compliments->setArguments($arguments);
        $clauses->setMessages($messages);
        $messages->setContexts($contexts);
        $messages->setStatements($statements);
        $messages->setUtterances($utterances);
        $contexts->setStatements($statements);
        $statements->setContexts($contexts);
        $utterances->setAuthors($authors);
        
        return new Cybe($authors);
    }
}
