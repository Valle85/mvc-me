<?php

namespace App\Controller;

use App\Entity\Book;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BookController extends AbstractController
{
    #[Route('/library', name: 'library_index')]
    public function index(BookRepository $bookRepo): Response
    {
        return $this->render('library/index.html.twig', [
            'books' => $bookRepo->findAll()
        ]);
    }

    #[Route('/library/create', name: 'library_create', methods: ['GET', 'POST'])]
    public function create(Request $request, ManagerRegistry $doctrine): Response
    {
        if ($request->isMethod('POST')) {
            $book = new Book();
            $book->setTitle($request->request->get('title'));
            $book->setIsbn($request->request->get('isbn'));
            $book->setAuthor($request->request->get('author'));
            $book->setImage($request->request->get('image'));

            $em = $doctrine->getManager();
            $em->persist($book);
            $em->flush();

            return $this->redirectToRoute('library_index');
        }


        return $this->render('library/create.html.twig');
    }

    #[Route('/library/book/{id}', name: 'library_show')]
    public function show(BookRepository $bookRepo, int $id): Response
    {
        $book = $bookRepo->find($id);
        return $this->render('library/show.html.twig', ['book' => $book]);
    }

    #[Route('/library/update/{id}', name: 'library_update', methods: ['GET', 'POST'])]
    public function update(Request $request, ManagerRegistry $doctrine, int $id): Response
    {
        $em = $doctrine->getManager();
        $book = $em->getRepository(Book::class)->find($id);

        if (!$book) {
            throw $this->createNotFoundException("Book not found");
        }

        if ($request->isMethod('POST')) {
            $book->setTitle($request->request->get('title'));
            $book->setIsbn($request->request->get('isbn'));
            $book->setAuthor($request->request->get('author'));
            $book->setImage($request->request->get('image'));
            $em->flush();

            return $this->redirectToRoute('library_index');
        }

        return $this->render('library/update.html.twig', ['book' => $book]);
    }

    #[Route('/library/delete/{id}', name: 'library_delete')]
    public function delete(ManagerRegistry $doctrine, int $id): Response
    {
        $em = $doctrine->getManager();
        $book = $em->getRepository(Book::class)->find($id);

        if ($book) {
            $em->remove($book);
            $em->flush();
        }

        return $this->redirectToRoute('library_index');
    }

    #[Route('/library/reset', name: 'library_reset')]
    public function reset(ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $repo = $em->getRepository(Book::class);

        foreach ($repo->findAll() as $book) {
            $em->remove($book);
        }

        $b1 = new Book();
        $b1->setTitle('Det slutar med oss')->setIsbn('9789188803719')->setAuthor(' Colleen Hoover')->setImage('img/slutar.jpg');
        $b2 = new Book();
        $b2->setTitle('Det börjar med oss')->setIsbn('9789189589612')->setAuthor('Colleen Hoover')->setImage('img/borjar.jpg');
        $b3 = new Book();
        $b3->setTitle('Förbannade kärlek')->setIsbn('9789188801104')->setAuthor('Colleen Hoover')->setImage('img/karlek.jpg');

        $em->persist($b1);
        $em->persist($b2);
        $em->persist($b3);
        $em->flush();

        return $this->redirectToRoute('library_index');
    }
}
