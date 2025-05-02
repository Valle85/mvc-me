<?php

namespace App\Tests\Card;

use PHPUnit\Framework\TestCase;
use App\Card\Card;
use App\Card\CardHand;

/**
 * Test cases for class CardHand.
 */
class CardHandTest extends TestCase
{
    /**
     * Add cards and test getNumberCards and getString.
     */
    public function testCardHandMethods()
    {
        $hand = new CardHand();
        $card1 = new Card("A", "hearts");
        $card2 = new Card("K", "spades");

        $hand->add($card1);
        $hand->add($card2);

        $this->assertEquals(2, $hand->getNumberCards());

        $strings = $hand->getString();
        $this->assertCount(2, $strings);
        $this->assertContains("[Ahearts]", $strings);
        $this->assertContains("[Kspades]", $strings);
    }
}
