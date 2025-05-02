<?php

namespace App\Tests\Game;

use PHPUnit\Framework\TestCase;
use App\Game\Game21;

/**
 * Test cases for class Game21.
 */
class Game21Test extends TestCase
{
    /**
     * Test construction and getters.
     */
    public function testCreateGameAndGetters()
    {
        $game = new Game21("Valeriia");
        $this->assertEquals("Valeriia", $game->getPlayer()->getName());
        $this->assertNotNull($game->getBank());
        $this->assertNotNull($game->getDeck());
    }

    /**
     * Test that player can draw a card.
     */
    public function testPlayerDrawCard()
    {
        $game = new Game21();
        $initial = $game->getPlayer()->getHand()->getNumberCards();
        $game->playerDrawCard();
        $new = $game->getPlayer()->getHand()->getNumberCards();
        $this->assertEquals($initial + 1, $new);
    }

    /**
     * Test winner logic by drawing many cards to bust player.
     */
    public function testGetWinner()
    {
        $game = new Game21();

        $riggedDeck = $this->getMockBuilder(\App\Card\DeckOfCards::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['draw'])
            ->getMock();

        $riggedDeck->expects($this->exactly(3))
            ->method('draw')
            ->willReturnOnConsecutiveCalls(
                new \App\Card\Card("10", "hearts"),
                new \App\Card\Card("Q", "spades"),
                new \App\Card\Card("K", "diamonds")
            );

        $ref = new \ReflectionClass($game);
        $prop = $ref->getProperty('deck');
        $prop->setAccessible(true);
        $prop->setValue($game, $riggedDeck);

        $game->playerDrawCard();
        $game->playerDrawCard();
        $game->playerDrawCard();

        $result = $game->getWinner();
        $this->assertStringContainsString("Banken vinner", $result);
    }
}
