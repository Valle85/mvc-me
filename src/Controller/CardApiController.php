<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Card\DeckOfCards;
use App\Game\Game21;

class CardApiController extends AbstractController
{
    #[Route("/api/deck", name: "api_deck", methods: ["GET"])]
    public function deck(): JsonResponse
    {
        $deck = new DeckOfCards();
        $cards = $deck->getAll();

        $jsonCards = array_map(fn ($card) => "[{$card->getValue()}{$card->getSuitSymbol()}]", $cards);

        $response = new JsonResponse(["deck" => $jsonCards]);
        $response->setEncodingOptions(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        return $response;
    }

    #[Route("/api/deck/shuffle", name: "api_deck_shuffle", methods: ["POST"])]
    public function shuffle(SessionInterface $session): JsonResponse
    {
        $deck = new DeckOfCards();
        $deck->shuffle();

        $session->set("card_deck", $deck);

        $cards = array_map(fn ($card) => "[{$card->getValue()}{$card->getSuitSymbol()}]", $deck->getAll());

        $response = new JsonResponse(["deck" => $cards]);
        $response->setEncodingOptions(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        return $response;
    }

    #[Route("/api/deck/draw", name: "api_deck_draw", methods: ["POST"])]
    public function drawOne(SessionInterface $session): JsonResponse
    {
        $deck = $session->get("card_deck");

        if (!$deck) {
            $deck = new DeckOfCards();
            $session->set("card_deck", $deck);
        }

        $card = $deck->draw();
        $session->set("card_deck", $deck);

        $responseData = [
            "card" => $card ? "[{$card->getValue()}{$card->getSuitSymbol()}]" : null,
            "cards_left" => $deck->count()
        ];

        $response = new JsonResponse($responseData);
        $response->setEncodingOptions(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        return $response;
    }

    #[Route("/api/deck/draw/{number<\d+>}", name: "api_deck_draw_number", methods: ["POST"])]
    public function drawMultiple(int $number, SessionInterface $session): JsonResponse
    {
        $deck = $session->get("card_deck");

        if (!$deck) {
            $deck = new DeckOfCards();
            $session->set("card_deck", $deck);
        }

        $cards = $deck->drawMultiple($number);
        $session->set("card_deck", $deck);

        $responseData = [
            "cards" => array_map(fn ($card) => "[{$card->getValue()}{$card->getSuitSymbol()}]", $cards),
            "cards_left" => $deck->count()
        ];

        $response = new JsonResponse($responseData);
        $response->setEncodingOptions(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        return $response;
    }

    #[Route("/api/game", name: "api_game_status", methods: ["GET"])]
    public function gameStatus(SessionInterface $session): JsonResponse
    {
        $game = $session->get("game21");

        if (!$game instanceof Game21) {
            return new JsonResponse(["error" => "Spelet har inte startat."], 404);
        }

        $playerHand = $game->getPlayer()->getHand()->getString();
        $playerScore = $game->getPlayer()->getTotalValue();

        $bankHand = $game->getBank()->getHand()->getString();
        $bankScore = $game->getBank()->getTotalValue();

        $result = $session->get("game21_result");

        $data = [
            "player" => [
                "hand" => $playerHand,
                "score" => $playerScore
            ],
            "bank" => [
                "hand" => $bankHand,
                "score" => $bankScore
            ],
            "result" => $result
        ];

        $response = new JsonResponse($data, 200);
        $response->setEncodingOptions(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        return $response;
    }
}
