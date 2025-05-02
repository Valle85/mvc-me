<?php

namespace App\Game;

use App\Card\CardHand;
use App\Card\Card;

/**
 * Represents the bank in the Game21 card game.
 * The bank holds a hand of cards and calculates its total value.
 */
class Bank
{
    private CardHand $hand;

    /**
     * Constructor initializes an empty hand.
     */
    public function __construct()
    {
        $this->hand = new CardHand();
    }

    /**
     * Get the hand of the bank.
     *
     * @return CardHand The current hand of the bank.
     */
    public function getHand(): CardHand
    {
        return $this->hand;
    }

    /**
     * Add a card to the bank's hand.
     *
     * @param Card $card The card to add.
     */

    public function takeCard(Card $card): void
    {
        $this->hand->add($card);
    }

    /**
     * Calculate the total value of the bank's hand,
     * treating Aces as 1 or 14 if it fits under 21.
     *
     * @return int The total value of the hand.
     */
    public function getTotalValue(): int
    {
        $values = $this->hand->getValues();
        $total = 0;
        $numAces = 0;

        foreach ($values as $value) {
            if ($value === "A") {
                $numAces++;
                $total += 1;
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

        return $total;
    }
}
