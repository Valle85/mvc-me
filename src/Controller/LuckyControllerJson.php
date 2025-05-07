<?php

namespace App\Controller;

use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LuckyControllerJson extends AbstractController
{
    #[Route("/api/lucky/number", name: "api_lucky")]
    public function jsonNumber(): Response
    {
        $number = random_int(0, 100);

        $data = [
            'lucky-number' => $number,
            'lucky-message' => 'Hi there!',
        ];

        // return new JsonResponse($data);
        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/api/quote", name: "api_quote")]
    public function quote(): Response
    {
        $quotes = [
            "'Programming isn't about what you know; it's about what you can figure out.' - Chris Pine",
            "'Sometimes it's better to leave something alone, to pause, and that's very true of programming.' - Joyce Wheeler",
            "'Testing leads to failure, and failure leads to understanding.' - Burt Rutan"
        ];

        $randomQuote = $quotes[array_rand($quotes)];

        $data = [
            'quote' => $randomQuote,
            'date' => date('Y-m-d'),
            'timestamp' => date('H:i:s')
        ];

        return $this->json($data, 200, [], ['json_encode_options' => JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE]);
    }

    #[Route("/api/", name: "api_index")]
    public function index(BookRepository $bookRepo): Response
    {
        $books = $bookRepo->findAll();
        return $this->render('api/index.html.twig', [
            'books' => $books
        ]);
    }
}
