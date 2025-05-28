<?php

namespace App\Tests\Poker;

use PHPUnit\Framework\TestCase;
use App\Poker\PokerHandEvaluator;
use App\Card\CardGraphic;

class PokerHandEvaluatorTest extends TestCase
{
    public function testPairDetection(): void
    {
        $evaluator = new PokerHandEvaluator();

        $hand = [
            new CardGraphic("10", "hearts"),
            new CardGraphic("10", "spades"),
            new CardGraphic("2", "clubs"),
            new CardGraphic("4", "diamonds"),
            new CardGraphic("6", "spades"),
        ];

        $result = $evaluator->evaluate($hand);
        $this->assertStringContainsString("Par", $result);
    }

    public function testFlushDetection(): void
    {
        $evaluator = new PokerHandEvaluator();

        $hand = [
            new CardGraphic("2", "hearts"),
            new CardGraphic("5", "hearts"),
            new CardGraphic("8", "hearts"),
            new CardGraphic("J", "hearts"),
            new CardGraphic("K", "hearts"),
        ];

        $result = $evaluator->evaluate($hand);
        $this->assertStringContainsString("Färg", $result);
    }

    public function testTwoPair(): void
    {
        $evaluator = new PokerHandEvaluator();

        $hand = [
            new CardGraphic("10", "hearts"),
            new CardGraphic("10", "spades"),
            new CardGraphic("3", "clubs"),
            new CardGraphic("3", "diamonds"),
            new CardGraphic("7", "spades"),
        ];

        $result = $evaluator->evaluate($hand);
        $this->assertSame("Två par", $result);
    }

    public function testThreeOfAKind(): void
    {
        $evaluator = new PokerHandEvaluator();

        $hand = [
            new CardGraphic("K", "hearts"),
            new CardGraphic("K", "spades"),
            new CardGraphic("K", "clubs"),
            new CardGraphic("5", "diamonds"),
            new CardGraphic("9", "hearts"),
        ];

        $result = $evaluator->evaluate($hand);
        $this->assertSame("Triss", $result);
    }

    public function testFullHouse(): void
    {
        $evaluator = new PokerHandEvaluator();

        $hand = [
            new CardGraphic("Q", "hearts"),
            new CardGraphic("Q", "spades"),
            new CardGraphic("Q", "clubs"),
            new CardGraphic("2", "diamonds"),
            new CardGraphic("2", "hearts"),
        ];

        $result = $evaluator->evaluate($hand);
        $this->assertSame("Kåk", $result);
    }

    public function testFourOfAKind(): void
    {
        $evaluator = new PokerHandEvaluator();

        $hand = [
            new CardGraphic("A", "hearts"),
            new CardGraphic("A", "spades"),
            new CardGraphic("A", "clubs"),
            new CardGraphic("A", "diamonds"),
            new CardGraphic("7", "hearts"),
        ];

        $result = $evaluator->evaluate($hand);
        $this->assertSame("Fyrtal", $result);
    }

    public function testHighCard(): void
    {
        $evaluator = new PokerHandEvaluator();

        $hand = [
            new CardGraphic("2", "hearts"),
            new CardGraphic("4", "spades"),
            new CardGraphic("6", "clubs"),
            new CardGraphic("9", "diamonds"),
            new CardGraphic("J", "hearts"),
        ];

        $result = $evaluator->evaluate($hand);
        $this->assertSame("Högsta kort", $result);
    }


    public function testCompareEqualHands(): void
    {
        $evaluator = new PokerHandEvaluator();

        $hand1 = [
            new CardGraphic("9", "spades"),
            new CardGraphic("9", "hearts"),
            new CardGraphic("5", "clubs"),
            new CardGraphic("7", "diamonds"),
            new CardGraphic("2", "clubs"),
        ];

        $hand2 = [
            new CardGraphic("9", "diamonds"),
            new CardGraphic("9", "clubs"),
            new CardGraphic("4", "hearts"),
            new CardGraphic("6", "spades"),
            new CardGraphic("3", "hearts"),
        ];

        $result1 = $evaluator->evaluate($hand1);
        $result2 = $evaluator->evaluate($hand2);

        $comparison = $evaluator->compare($result1, $result2);
        $this->assertIsString($comparison);
    }
}
