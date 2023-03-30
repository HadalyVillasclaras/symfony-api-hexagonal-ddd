<?php

namespace App\Controller;
use App\MyDashboard\Books;
use App\MyDashboard\Books\Application\AddBookRequest;
use App\MyDashboard\Books\Application\AddBookService;
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

  // public function create(Request $request, EntityManagerInterface $entityManagerInterface): JsonResponse
  // {
  //   $book = new Book();
  //   $title = $request->get('title', null);
   

  //   $response = new JsonResponse();
  //   if(empty($title)){
  //     $response->setData([
  //       'success' => false,
  //       'error' => 'title cannot be empty',
  //       'data' => null
  //     ]);
  //     return $response;
  //   }
  //   $book->setTitle($title);
  //   $book->setAuthor('AUTOR');
  //   $book->setLanguage('en');
  //   $book->setPages(343);
  //   $response->setData([
  //     'success' => true,
  //     "data" => [
  //       [
  //         'id' => $book->getId(),
  //         'title' => $book->getTitle()
  //       ]
  //     ]
  //   ]);

  //   $entityManagerInterface->persist($book);
  //   $entityManagerInterface->flush();


  //   return $response;
  // }


  /**
   * @Route("/books/create", name="books_create" methods={"POST"})
   */
  public function create(Request $request, AddBookService $addBookService) 
  {

    $requestParams = json_decode($request->getContent(), true);

    $createBookRequestParams = [];
    $createBookRequestParams['title'] =  $requestParams['title'] ?? null;
    $createBookRequestParams['subtitle'] =  $requestParams['subtitle'] ?? null;
    $createBookRequestParams['author'] =  $requestParams['author'] ?? null;
    $createBookRequestParams['year'] =  $requestParams['year'] ?? null;
    $createBookRequestParams['category'] =  $requestParams['category'] ?? null;
    $createBookRequestParams['language'] =  $requestParams['language'] ?? null;
    $createBookRequestParams['country'] =  $requestParams['country'] ?? null;
    $createBookRequestParams['pages'] =  $requestParams['pages'] ?? null;
    $createBookRequestParams['price'] =  $requestParams['price'] ?? null;
    $createBookRequestParams['link'] =  $requestParams['link'] ?? null;
    $createBookRequestParams['status'] =  $requestParams['status'] ?? null;
    $createBookRequestParams['isbn'] =  $requestParams['isbn'] ?? null;
    $createBookRequestParams['url'] =  $requestParams['url'] ?? null;
    $createBookRequestParams['description'] =  $requestParams['description'] ?? null;

    $createBookRequest = new AddBookRequest(
      $createBookRequestParams['title'],
      $createBookRequestParams['subtitle'],
      $createBookRequestParams['author'],
      $createBookRequestParams['year'],
      $createBookRequestParams['category'],
      $createBookRequestParams['language'],
      $createBookRequestParams['country'],
      $createBookRequestParams['pages'],
      $createBookRequestParams['price'],
      $createBookRequestParams['link'],
      $createBookRequestParams['status'],
      $createBookRequestParams['isbn'],
      $createBookRequestParams['url'],
      $createBookRequestParams['description']
    );

    $addBookService->execute($createBookRequest);
  }
}