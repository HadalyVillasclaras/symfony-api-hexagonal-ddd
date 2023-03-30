<?php

namespace App\Controller;
use App\MyDashboard\Books
;
use App\MyDashboard\Books\Domain\Book;
use App\MyDashboard\Books\Domain\BookRepositoryInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Error;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class BookController extends AbstractController
{
  /**
   * @Route("/books", name="books_get_all", methods={"GET"})
   */
  public function getAll(Request $request, BookRepositoryInterface $bookRepositoryInterface): Response
  {  
    $title = $request->get('title', 'Cumbres');
    $books = $bookRepositoryInterface->findAll();
    $booksArray = [];
    foreach ($books as $book) {
      $booksArray[] = [
        'id' => $book->getId(),
        'title' => $book->getTitle(),
        'author' => $book->getAuthor(),
        'language' => $book->getLanguage(),
        'pages' => $book->getPages()
      ];
    }
    $response = new JsonResponse();
    $response->setData([
      'success' => 'true',
      'data' => $booksArray
    ]);
    return $response;
  }

  /**
   * @Route("/books/create", name="books_create")
   */
  public function create(Request $request, EntityManagerInterface $entityManagerInterface) 
  {
    $book = new Book();
    $title = $request->get('title', null);
   

    $response = new JsonResponse();
    if(empty($title)){
      $response->setData([
        'success' => false,
        'error' => 'title cannot be empty',
        'data' => null
      ]);
      return $response;
    }
    $book->setTitle($title);
    $book->setAuthor('AUTOR');
    $book->setLanguage('en');
    $book->setPages(343);
    $response->setData([
      'success' => true,
      "data" => [
        [
          'id' => $book->getId(),
          'title' => $book->getTitle()
        ]
      ]
    ]);

    $entityManagerInterface->persist($book);
    $entityManagerInterface->flush();


    return $response;
  }
}