<?php

namespace App\Dice;

class DiceHandFactory
{
    public function createHand(int $num): DiceHand
    {
        if ($num > 99) {
            throw new \InvalidArgumentException("Can not roll more than 99 dices!");
        }

        $hand = new DiceHand();
        for ($i = 1; $i <= $num; $i++) {
            if ($i % 2 === 1) {
                $hand->add(new DiceGraphic());
            } else {
                $hand->add(new Dice());
            }
        }
        $hand->roll();

        return $hand;
    }
}
