<?php

namespace App\Game;

use App\Card\CardHand;
use App\Card\Card;

/**
 * Represents a player in the Game21 card game.
 * The player has a name, a hand of cards, and can draw cards and calculate their total value.
 */
class Player
{
    private string $name;
    private CardHand $hand;

    /**
     * Constructor sets the player's name and creates an empty hand.
     *
     * @param string $name The name of the player.
     */
    public function __construct(string $name = "")
    {
        $this->name = $name;
        $this->hand = new CardHand();
    }

    /**
     * Get the player's name.
     *
     * @return string The name of the player.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the player's hand.
     *
     * @return CardHand The current hand of the player.
     */
    public function getHand(): CardHand
    {
        return $this->hand;
    }

    /**
     * Add a card to the player's hand.
     *
     * @param Card $card The card to add.
     */
    public function takeCard(Card $card): void
    {
        $this->hand->add($card);
    }

    /**
     * Calculate the total value of the player's hand,
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
