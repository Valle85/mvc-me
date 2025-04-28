<?php

namespace App\Controller;

use App\Card\DeckOfCards;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
// use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CardGameController extends AbstractController
{
    #[Route("/card", name: "card_home")]
    public function home(): Response
    {
        return $this->render('card/home.html.twig');
    }

    #[Route("/card/deck", name: "card_deck")]
    public function showDeck(): Response
    {
        $deck = new DeckOfCards();

        $data = [
            "deck" => $deck->getAll()
        ];

        return $this->render('card/deck.html.twig', $data);
    }

    #[Route("/card/deck/shuffle", name: "card_deck_shuffle")]
    public function shuffleDeck(SessionInterface $session): Response
    {
        $deck = new DeckOfCards();
        $deck->shuffle();

        $session->set("card_deck", $deck);

        $data = [
            "deck" => $deck->getAll()
        ];

        return $this->render('card/deck.html.twig', $data);
    }

    #[Route("/card/deck/draw", name: "card_deck_draw")]
    public function drawOne(SessionInterface $session): Response
    {
        $deck = $session->get("card_deck");
    
        if (!$deck) {
            $deck = new DeckOfCards();
            $session->set("card_deck", $deck); // Viktigt!
        }
    
        $card = $deck->draw();
        $session->set("card_deck", $deck); // Spara alltid tillbaka efter dragning
    
        $data = [
            "card" => $card,
            "cardsLeft" => $deck->count(),
        ];
    
        return $this->render('card/draw.html.twig', $data);
    }

    #[Route("/card/deck/draw/{number<\d+>}", name: "card_deck_draw_number")]
    public function drawMultiple(int $number, SessionInterface $session): Response
    {
        $deck = $session->get("card_deck");
    
        if (!$deck) {
            $deck = new DeckOfCards();
            $session->set("card_deck", $deck); // Viktigt!
        }
    
        $cards = $deck->drawMultiple($number);
        $session->set("card_deck", $deck); // Spara alltid tillbaka efter dragning
    
        $data = [
            "cards" => $cards,
            "cardsLeft" => $deck->count(),
            "requested" => $number
        ];
    
        return $this->render('card/draw_many.html.twig', $data);
    }

    #[Route("/card/session", name: "card_session")]
    public function sessionView(SessionInterface $session): Response
    {
        $data = [
            "session" => $session->all()
        ];

        return $this->render('card/session.html.twig', $data);
    }

    #[Route("/card/session/delete", name: "card_session_delete")]
    public function sessionDelete(SessionInterface $session): Response
    {
        $session->clear();

        $this->addFlash("notice", "Sessionen är nu rensad.");

        return $this->redirectToRoute('card_home');
    }

    #[Route("/game", name: "game_landing")]
    public function landing(): Response
    {
        return $this->render('card/landing.html.twig');
    }

    #[Route("/game/doc", name: "game_doc")]
    public function documentation(): Response
    {
        return $this->render('game/doc.html.twig');
    }
}
