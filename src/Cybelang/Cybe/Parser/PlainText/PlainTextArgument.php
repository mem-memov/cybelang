<?php

namespace MemMemov\Cybelang\Cybe\Parser\PlainText;

use MemMemov\Cybelang\Cybe\Parser\Argument;
use MemMemov\Cybelang\Cybe\Parser\Category;
use MemMemov\Cybelang\Cybe\Parser\Compliment;

class PlainTextArgument implements Argument
{
    private static $separator = ':';

    private $categories;
    private $compliments;
    private $string;

    public function __construct(
        PlainTextCategories $categories,
        PlainTextCompliments $compliments,
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