<?php

namespace App\Controller;

use App\Poker\PokerHandEvaluator;
use App\Card\DeckOfCards;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class PokerGameController extends AbstractController
{
    #[Route("/proj/play", name: "poker_play")]
    public function play(SessionInterface $session): Response
    {
        if (!$session->has("poker_money")) {
            $session->set("poker_money", 1000);
        }

        $money = $session->get("poker_money", 0);
        if ($money <= 0) {
            return $this->render('proj/gameover.html.twig');
        }

        if (!$session->has("poker_deck")) {
            $deck = new DeckOfCards();
            $deck->shuffle();

            $playerHand = $deck->drawMultiple(5);
            $computerHand = $deck->drawMultiple(5);

            $session->set("poker_deck", $deck);
            $session->set("player_hand", $playerHand);
            $session->set("computer_hand", $computerHand);
            $session->set("poker_exchanges", 0);
            $session->remove("player_result");
            $session->remove("computer_result");
            $session->remove("poker_winner");
        }
        $playerHand = $session->get("player_hand", []);
        $computerHand = $session->get("computer_hand", []);
        $exchanges = $session->get("poker_exchanges", 0);
        $canExchange = $exchanges < 3;

        $playerResult = $session->get("player_result", null);
        $computerResult = $session->get("computer_result", null);
        $winner = $session->get("poker_winner", null);

        return $this->render('proj/play.html.twig', [
            "player" => $playerHand,
            "computer" => $computerHand,
            "canExchange" => $canExchange,
            "playerResult" => $playerResult,
            "computerResult" => $computerResult,
            "winner" => $winner,
            "money" => $money
        ]);
    }

    #[Route("/proj/exchange", name: "poker_exchange", methods: ["POST"])]
    public function exchange(SessionInterface $session, Request $request): Response
    {
        $deck = $session->get("poker_deck");
        $playerHand = $session->get("player_hand");

        if (!$deck || !$playerHand) {
            return $this->redirectToRoute('poker_play');
        }

        $exchangeIndexes = $request->request->all('exchange') ?? [];

        foreach ($exchangeIndexes as $index) {
            $playerHand[$index] = $deck->draw();
        }

        $session->set("player_hand", $playerHand);
        $session->set("poker_deck", $deck);

        $exchanges = $session->get("poker_exchanges", 0);
        $exchanges++;
        $session->set("poker_exchanges", $exchanges);

        if ($exchanges >= 3) {
            $computerHand = $session->get("computer_hand");

            $evaluator = new PokerHandEvaluator();
            $playerResult = $evaluator->evaluate($playerHand);
            $computerResult = $evaluator->evaluate($computerHand);
            $winner = $evaluator->compare($playerResult, $computerResult);

            $bet = $session->get("poker_bet", 0);
            $money = $session->get("poker_money", 0);

            if ($winner === "Spelaren vinner!") {
                $money += $bet;
            } elseif ($winner === "Datorn vinner!") {
                $money -= $bet;
            }

            $session->set("poker_money", $money);
            $session->set("player_result", $playerResult);
            $session->set("computer_result", $computerResult);
            $session->set("poker_winner", $winner);

            if ($money <= 0) {
                return $this->render('proj/gameover.html.twig', [
                    "player" => $playerHand,
                    "computer" => $computerHand,
                    "playerResult" => $playerResult,
                    "computerResult" => $computerResult,
                    "winner" => $winner
                ]);
            }
        }

        return $this->redirectToRoute('poker_play');
    }

    #[Route("/proj/bet", name: "poker_bet", methods: ["GET", "POST"])]
    public function bet(SessionInterface $session, Request $request): Response
    {
        if (!$session->has("poker_money") || $session->get("poker_money") <= 0) {
            $session->set("poker_money", 1000);
        }
        $money = $session->get("poker_money", 0);

        if ($money <= 0) {
            return $this->redirectToRoute("poker_reset");
        }
        if ($request->isMethod("POST")) {
            $amount = (int) $request->request->get("amount", 0);

            if ($amount > 0 && $amount <= $money) {
                $session->set("poker_bet", $amount);
                return $this->redirectToRoute("poker_play");
            }
        }

        return $this->render("proj/bet.html.twig", [
            "money" => $session->get("poker_money", 0)
        ]);
    }

    #[Route("/proj/reset", name: "poker_reset", methods: ["POST"])]
    public function reset(SessionInterface $session): Response
    {
        // $money = $session->get("poker_money", 1000);
        $session->clear();
        // $session->set("poker_money", $money);

        return $this->redirectToRoute('poker_bet');
    }
}
