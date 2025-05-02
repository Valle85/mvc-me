<?php

namespace App\Tests\Card;

use PHPUnit\Framework\TestCase;
use App\Card\CardGraphic;

/**
 * Test cases for class CardGraphic.
 */
class CardGraphicTest extends TestCase
{
    /**
     * Create a CardGraphic and verify it is correctly constructed.
     */
    public function testCreateCardGraphic()
    {
        $card = new CardGraphic("A", "hearts");
        $this->assertInstanceOf(CardGraphic::class, $card);
        $this->assertStringContainsString("♥", $card->getAsString());
    }
}
