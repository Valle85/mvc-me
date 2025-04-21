<?php

namespace App\Game;

use App\Card\CardHand;
use App\Card\Card;

class Player
{
    private string $name;
    private CardHand $hand;

    public function __construct(string $name = "")
    {
        $this->name = $name;
        $this->hand = new CardHand();
    }

    public function getName() {
        return $this->name;
    }

    public function getHand(): CardHand
    {
        return $this->hand;
    }

    public function takeCard(Card $card): void
    {
        $this->hand->add($card);
    }

    public function getTotalValue(): int 
    {
        $values=$this->hand->getValues();
        $total = 0;
        $numAces = 0;

        foreach ($values as $value) {
            if ($value === "A") {
                $numAces++;
                $total +=1;
            } elseif (in_array($value, ["J", "Q", "K"])) {
                $total += 10;
            } else {
                $total += (int)$value;
            }
        }

        while ($numAces > 0 && $total + 13 <= 21) {
            $total += 13;
            $numAces--;
        }
        return $total
    }
}