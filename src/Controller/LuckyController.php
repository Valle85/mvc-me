<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LuckyController extends AbstractController
{
    #[Route('/lucky', name: 'lucky')]
    public function lucky(): Response
    {
        $number = random_int(0, 100);

        return $this->render('lucky/lucky.html.twig', [
            'number' => $number,
        ]);
    }

    #[Route("/lucky/hi")]
    public function hi(): Response
    {
        return new Response(
            '<html><body>Hi to you!</body></html>'
        );
    }

    #[Route("/api/lucky/number")]
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
}
