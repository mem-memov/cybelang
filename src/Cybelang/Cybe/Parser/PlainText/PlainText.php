<?php

namespace MemMemov\Cybelang\Cybe\Parser\PlainText;

use MemMemov\Cybelang\Cybe\Parser\Messages;

class PlainText
{
    public function messages(): Messages
    {
        $categories = new PlainTextCategories();
        $compliments = new PlainTextCompliments();
        $arguments = new PlainTextArguments($categories, $compliments);
        $subjects = new PlainTextSubjects();
        $predicates = new PlainTextPredicates();
        $clauses = new PlainTextClauses($predicates, $subjects, $arguments);
        
        return new PlainTextMessages($clauses);
    }
}
