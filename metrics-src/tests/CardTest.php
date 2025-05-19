<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Card;

final class CardTest extends TestCase
{
    public function testGetCard(): void
    {
        $card = new Card("Hearts", "Queen");
        $this->assertSame("Queen of Hearts", $card->getCard());
    }
}
