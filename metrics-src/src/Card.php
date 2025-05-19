<?php

namespace App;

class Card
{
    private string $suit;
    private string $value;

    public function __construct(string $suit, string $value)
    {
        $this->suit = $suit;
        $this->value = $value;
    }

    public function getCard(): string
    {
        return "{$this->value} of {$this->suit}";
    }
}
