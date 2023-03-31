<?php

namespace App\Controller;
use App\MyDashboard\Books\Application\AddBookRequest;
use App\MyDashboard\Books\Application\AddBookService;
use App\MyDashboard\Books\Application\GetBooksService;
use App\MyDashboard\Books\Domain\BookRepositoryInterface;
use App\Ruralidays\Shared\Application\ApiResponse;
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
  public function getAll(GetBooksService $getBooksService): Response
  {
    $apiResponse = new ApiResponse();
    
    $books = $getBooksService->execute();

    $apiResponse->setData($books);

    foreach ($books as $book) {
      $booksArray[] = [
        'id' => $book->getId(),
        'title' => $book->getTitle(),
        'author' => $book->getAuthor(),
        'language' => $book->getLanguage(),
        'pages' => $book->getPages()
      ];
    }

    return $this->json($apiResponse->getOutput());
    // $booksArray = [];

    // foreach ($books as $book) {
    //   $booksArray[] = [
    //     'id' => $book->getId(),
    //     'title' => $book->getTitle(),
    //     'author' => $book->getAuthor(),
    //     'language' => $book->getLanguage(),
    //     'pages' => $book->getPages()
    //   ];
    // }

    // $response = new JsonResponse();
    // $response->setData([
    //   'success' => 'true',
    //   'data' => $booksArray
    // ]);
    // return $response;
  }

  // public function getAll(Request $request, BookRepositoryInterface $bookRepositoryInterface): Response
  // {  



  //   $title = $request->get('title', 'Cumbres');
  //   $books = $bookRepositoryInterface->findAll();
  //   $booksArray = [];
  //   foreach ($books as $book) {
  //     $booksArray[] = [
  //       'id' => $book->getId(),
  //       'title' => $book->getTitle(),
  //       'author' => $book->getAuthor(),
  //       'language' => $book->getLanguage(),
  //       'pages' => $book->getPages()
  //     ];
  //   }
  //   $response = new JsonResponse();
  //   $response->setData([
  //     'success' => 'true',
  //     'data' => $booksArray
  //   ]);
  //   return $response;
  // }

  /**
   * @Route("/books/create", name="books_create", methods={"POST"})
   */
  public function create(Request $request, AddBookService $addBookService) 
  {
    $requestParams = json_decode($request->getContent(), true);
    print_r($requestParams);
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
    echo 'title:';
    echo $createBookRequestParams['title'];

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