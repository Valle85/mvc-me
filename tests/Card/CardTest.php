<?php

namespace App\Tests\Card;

use PHPUnit\Framework\TestCase;
use App\Card\Card;

/**
 * Test cases for class Card.
 */
class CardTest extends TestCase
{
    /**
     * Construct object and verify basic getters.
     */
    public function testCreateCard()
    {
        $card = new Card("A", "hearts");
        $this->assertInstanceOf(Card::class, $card);

        $this->assertEquals("A", $card->getValue());
        $this->assertEquals("hearts", $card->getSuit());
        $this->assertEquals("[Ahearts]", $card->getAsString());
    }

    /**
     * Verify if suit is returned correctly.
     */
    public function testGetSuitSymbol()
    {
        $card = new Card("K", "spades");
        $this->assertEquals("♠", $card->getSuitSymbol());

        $card = new Card("Q", "diamonds");
        $this->assertEquals("♦", $card->getSuitSymbol());

        $card = new Card("J", "clubs");
        $this->assertEquals("♣", $card->getSuitSymbol());

        $card = new Card("10", "hearts");
        $this->assertEquals("♥", $card->getSuitSymbol());

        $card = new Card("2", "unknown");
        $this->assertEquals("unknown", $card->getSuitSymbol());
    }
}
