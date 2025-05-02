<?php

namespace App\Tests\Game;

use PHPUnit\Framework\TestCase;
use App\Game\Bank;
use App\Card\Card;

/**
 * Test cases for class Bank.
 */

class BankTest extends TestCase
{
    /**
     * Test that Bank can receive cards and calculate total value.
     */
    public function testBankTakeCardAndTotalValue()
    {
        $bank = new Bank();
        $this->assertEquals(0, $bank->getTotalValue());

        $bank->takeCard(new Card("A", "hearts"));
        $bank->takeCard(new Card("7", "spades"));
        $this->assertEquals(21, $bank->getTotalValue());

        $bank->takeCard(new Card("5", "clubs"));
        $this->assertEquals(13, $bank->getTotalValue());

        $bank->takeCard(new Card("K", "diamonds"));
        $this->assertEquals(23, $bank->getTotalValue());
    }
}
