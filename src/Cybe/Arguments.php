<?php

namespace MemMemov\Cybe;

class Arguments
{
    private $categories;
    private $compliments;

    public function __construct(
        Categories $categories,
        Compliments $compliments
    ) {
        $this->categories = $categories;
        $this->compliments = $compliments;
    }

    public function fromText(Parser\Argument $argumentText): Argument
    {
        $category = $this->categories->fromText($argumentText->category());
        $compliment = $this->compliments->fromText($argumentText->compliment());

        return new Argument(
            $category,
            $compliment
        );
    }
}