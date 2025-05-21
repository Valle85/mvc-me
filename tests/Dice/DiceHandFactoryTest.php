<?php

namespace App\Tests\Dice;

use PHPUnit\Framework\TestCase;
use App\Dice\DiceHandFactory;
use App\Dice\DiceHand;

class DiceHandFactoryTest extends TestCase
{
    public function testCreateHandReturnsCorrectTypeAndDiceCount()
    {
        $factory = new DiceHandFactory();
        $hand = $factory->createHand(6);

        $this->assertInstanceOf(DiceHand::class, $hand);
        $this->assertEquals(6, $hand->getNumberDices());

        $result = $hand->getString();
        $this->assertNotEmpty($result);
    }

    public function testCreateHandThrowsExceptionOver99()
    {
        $this->expectException(\InvalidArgumentException::class);

        $factory = new DiceHandFactory();
        $factory->createHand(100);
    }
}
