<?php

namespace App\Card;

class CardGraphic extends Card
{
    private $suitSymbols = [
        "hearts" => "♥",
        "diamonds" => "♦",
        "clubs" => "♣",
        "spades" => "♠",
    ];

    public function __construct(string $value, string $suit)
    {
        parent::__construct($value, $suit);
    }

    public function getAsString(): string
    {
        $symbol = $this->suitSymbols[strtolower($this->suit)] ?? $this->suit;
        $coloredSymbol = in_array(strtolower($this->suit), ["hearts", "diamonds"])
            ? "<span style='color: red;'>{$symbol}</span>"
            : $symbol;
        return "[{$this->value}{$coloredSymbol}]";
    }
}
