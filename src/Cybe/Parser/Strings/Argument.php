<?php

namespace MemMemov\Cybe\Parser\Strings;

class Argument
{
    private static $separator = ':';

    private $categories;
    private $compliments;
    private $string;

    public function __construct(
        Categories $categories,
        Compliments $compliments,
        string $string
    ) {
        $this->categories = $categories;
        $this->compliments = $compliments;
        $this->string = $string;
    }

    public function category(): Category
    {
        $categoryString = strtok($this->string, self::$separator);

        $category = $this->categories->create($categoryString);

        return $category;
    }

    public function compliment(): Compliment
    {
        $separatorPosition = strpos($this->string, self::$separator);

        $complimentString = substr($this->string, $separatorPosition + 1);

        $compliment = $this->compliments->create($complimentString);

        return $compliment;
    }
}