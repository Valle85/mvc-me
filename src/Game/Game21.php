<?php

namespace App\Game;

use App\Card\DeckOfCards;
use App\Card\CardHand;
use App\Game\Player;
use App\Game\Bank;

/**
 * Controls the logic of the Game21 card game.
 * Manages a player, a bank, and a deck of cards.
 */
class Game21
{
    private Player $player;
    private Bank $bank;
    private DeckOfCards $deck;

    /**
     * Constructor initializes player, bank, and shuffled deck.
     *
     * @param string $playerName The name of the player.
     */
    public function __construct(string $playerName = "Spelare")
    {
        $this->player = new Player($playerName);
        $this->bank = new Bank();
        $this->deck = new DeckOfCards();
        $this->deck->shuffle();
    }

    /**
     * Get the player object.
     *
     * @return Player The player.
     */
    public function getPlayer()
    {
        return $this->player;
    }

    /**
     * Get the bank object.
     *
     * @return Bank The bank.
     */
    public function getBank(): Bank
    {
        return $this->bank;
    }

    /**
     * Get the deck of cards.
     *
     * @return DeckOfCards The deck.
     */
    public function getDeck(): DeckOfCards
    {
        return $this->deck;
    }

    /**
     * Let the player draw one card from the deck.
     */
    public function playerDrawCard(): void
    {
        $card = $this->deck->draw();
        if ($card) {
            $this->player->takeCard($card);
        }
    }

    /**
     * Let the bank draw cards until the total is at least 17.
     */
    public function bankTurn(): void
    {
        while ($this->bank->getTotalValue() < 17) {
            $card = $this->deck->draw();
            if ($card) {
                $this->bank->takeCard($card);
            }
        }
    }

    /**
     * Determine who wins the game based on total values.
     *
     * @return string A message declaring the winner.
     */
    public function getWinner(): string
    {
        $playerScore = $this->player->getTotalValue();
        $bankScore = $this->bank->getTotalValue();

        if ($playerScore > 21) {
            return "Banken vinner (Spelaren: {$playerScore}, Banken: {$bankScore})";
        }

        if ($bankScore > 21) {
            return "Spelaren vinner (Spelaren: {$playerScore}, Banken: {$bankScore})";
        }

        if ($bankScore >= $playerScore) {
            return "Banken vinner (Spelaren: {$playerScore}, Banken: {$bankScore})";
        }

        return "Spelaren vinner (Spelaren: {$playerScore}, Banken: {$bankScore})";
    }
}
