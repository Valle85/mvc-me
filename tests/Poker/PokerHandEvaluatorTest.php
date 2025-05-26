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
        $this->assertStringContainsString("Färg", $result); // eller "Flush"
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
        $this->assertIsString($comparison); // Exempel: "Spelaren vinner!" eller "Datorn vinner!"
    }
}
