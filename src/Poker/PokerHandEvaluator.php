<?php

namespace App\Poker;

class PokerHandEvaluator
{
    public function evaluate(array $hand): string
    {
        $values = [];
        $suits = [];

        foreach ($hand as $card) {
            $values[] = $card->getValue();
            $suits[] = $card->getSuit();
        }

        $counts = array_count_values($values);
        arsort($counts);

        $mostCommon = reset($counts);

        if ($mostCommon == 4) {
            return "Fyrtal";
        }

        if ($mostCommon == 3 && in_array(2, $counts)) {
            return "Kåk";
        }

        if ($mostCommon == 3) {
            return "Triss";
        }

        if ($mostCommon == 2 && count($counts) == 3) {
            return "Två par";
        }

        if ($mostCommon == 2) {
            return "Par";
        }

        if (count(array_unique($suits)) == 1) {
            return "Färg";
        }

        return "Högsta kort";
    }

    private array $ranking = [
        "Högsta kort" => 1,
        "Par" => 2,
        "Två par" => 3,
        "Triss" => 4,
        "Färg" => 5,
        "Kåk" => 6,
        "Fyrtal" => 7
    ];

    public function compare(string $hand1, string $hand2): string
    {
        $r1 = $this->ranking[$hand1] ?? 0;
        $r2 = $this->ranking[$hand2] ?? 0;

        if ($r1 > $r2) {
            return "Spelaren vinner!";
        }

        if ($r1 < $r2) {
            return "Datorn vinner!";
        }

        return "Oavgjort!";
    }
}
