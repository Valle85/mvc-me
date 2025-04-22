<?php

namespace App\Game;

use App\Card\DeckOfCards;
use App\Card\CardHand;
use App\Game\Player;
use App\Game\Bank;

class Game21
{
    private Player $player;
    private Bank $bank;
    private DeckOfCards $deck;

    public function __construct(string $playerName = "Spelare")
    {
        $this->player = new Player($playerName);
        $this->bank = new Bank();
        $this->deck = new DeckOfCards();
        $this->deck->shuffle();
    }

    public function getPlayer()
    {
        return $this->player;
    }

    public function getBank(): Bank
    {
        return $this->bank;
    }

    public function getDeck(): DeckOfCards
    {
        return $this->deck;
    }

    public function playerDrawCard(): void
    {
        $card = $this->deck->draw();
        if ($card) {
            $this->player->takeCard($card);
        }
    }

    public function bankTurn(): void
    {
        while ($this->bank->getTotalValue() < 17) {
            $card = $this->deck->draw();
            if ($card) {
                $this->bank->takeCard($card);
            }
        }
    }

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
