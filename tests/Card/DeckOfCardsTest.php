<?php

namespace App\Tests\Card;

use PHPUnit\Framework\TestCase;
use App\Card\DeckOfCards;
use App\Card\CardGraphic;

/**
 * Test cases for class DeckOfCards.
 */
class DeckOfCardsTest extends TestCase
{
    /**
     * Test deck creation and contents.
     */
    public function testDeckCreation()
    {
        $deck = new DeckOfCards();
        $all = $deck->getAll();

        $this->assertCount(52, $all);

        $cards = array_map(fn ($card) => $card->getValue() . $card->getSuitSymbol(), $all);

        $this->assertContains("A♥", $cards);
        $this->assertContains("K♥", $cards);
        $this->assertContains("Q♠", $cards);
    }

    /**
     * Test draw method reduces deck size.
     */
    public function testDrawCard()
    {
        $deck = new DeckOfCards();
        $card = $deck->draw();

        $this->assertInstanceOf(CardGraphic::class, $card);
        $this->assertCount(51, $deck->getAll());
    }
}
