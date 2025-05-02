<?php

namespace App\Tests\Game;

use PHPUnit\Framework\TestCase;
use App\Game\Player;
use App\Card\Card;

/**
 * Test cases for class Player.
 */
class PlayerTest extends TestCase
{
    /**
     * Test getName and takeCard.
     */
    public function testGetNameAndTakeCard()
    {
        $player = new Player("Valeriia");
        $this->assertEquals("Valeriia", $player->getName());

        $this->assertEquals(0, $player->getHand()->getNumberCards());

        $player->takeCard(new Card("Q", "hearts"));
        $this->assertEquals(1, $player->getHand()->getNumberCards());
    }

    /**
     * Test calculation of total value.
     */
    public function testGetTotalValue()
    {
        $player = new Player();
        $player->takeCard(new Card("A", "hearts"));
        $player->takeCard(new Card("7", "clubs"));
        $this->assertEquals(21, $player->getTotalValue());

        $player->takeCard(new Card("5", "spades"));
        $this->assertEquals(13, $player->getTotalValue());
    }
}
