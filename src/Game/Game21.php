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
}