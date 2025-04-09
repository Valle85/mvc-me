<?php

namespace App\Card;

class DeckOfCards
{
    private $deck = [];

    private $suits = ["hearts", "diamonds", "clubs", "spades"];
    private $values = ["A", "2", "3", "4", "5", "6", "7", "8", "9", "10", "J", "Q", "K"];

    public function __construct()
    {
        foreach ($this->suits as $suit) {
            foreach ($this->values as $value) {
                $this->deck[] = new CardGraphic($value, $suit);
            }
        }
    }

    public function shuffle(): void
    {
        shuffle($this->deck);
    }

    public function draw(): ?Card
    {
        return array_shift($this->deck);
    }

    public function drawMultiple(int $number): array
    {
        $cards = [];
        for ($i = 0; $i < $number; $i++) {
            $card = $this->draw();
            if ($card) {
                $cards[] = $card;
            }
        }
        return $cards;
    }

    public function getAll(): array
    {
        return $this->deck;
    }

    public function count(): int
    {
        return count($this->deck);
    }
}
