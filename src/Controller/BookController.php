<?php

namespace App\Controller;

use App\MyDashboard\Books\Application\AddBookRequest;
use App\MyDashboard\Books\Application\AddBookService;
use App\MyDashboard\Books\Application\DeleteBookRequest;
use App\MyDashboard\Books\Application\DeleteBookService;
use App\MyDashboard\Books\Application\GetBookRequest;
use App\MyDashboard\Books\Application\GetBookService;
use App\MyDashboard\Books\Application\GetBooksService;
use App\MyDashboard\Books\Application\UpdateBookRequest;
use App\MyDashboard\Books\Application\UpdateBookService;
use App\MyDashboard\Shared\Application\ApiResponse;
use Error;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    try {
      $books = $getBooksService->execute();
      $apiResponse->setData($books);
    } catch (Exception $e) {
      $apiResponse->setError($e->getMessage(), $e->getCode());
    } catch (Error $e) {
      $apiResponse->setError($e->getMessage(), $e->getCode());
    }
    return $this->json($apiResponse->getApiResponse());
  }

  /**
   * @Route("books/{id}", name="books_get", methods={"GET"})
   */
  public function getById(GetBookService $geBookService, int $id): Response
  {
      $apiResponse = new ApiResponse();

      try {
          $getBookRequest = new GetBookRequest($id);

          $book = $geBookService->execute($getBookRequest);

          $apiResponse->setData($book->__toArray());
      }catch(Exception $e){
          $apiResponse->setError($e->getMessage(), $e->getCode());
      } catch (Error $e) {
          $apiResponse->setError($e->getMessage(), $e->getCode());
      }

      return $this->json($apiResponse->getApiResponse());
  }

  /**
   * @Route("/books/create", name="books_create", methods={"POST"})
   */
  public function create(Request $request, AddBookService $addBookService) 
  {
    $apiResponse = new ApiResponse();

    try {
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
  
      $book = $addBookService->execute($createBookRequest);
      $apiResponse->setData($book->__toArray());
    } catch (Exception $e) {
      $apiResponse->setError($e->getMessage(), $e->getCode());
    } catch (Error $e) {
      $apiResponse->setError($e->getMessage(), $e->getCode());
    }

    return $this->json($apiResponse->getApiResponse());
  }

  /**
   * @Route("/books/{id}", name="update", methods={"PUT"})
   */
  public function update(Request $request, UpdateBookService $updateBookService, int $id): Response
  {
    $apiResponse = new ApiResponse();

    try {
      $requestParams = json_decode($request->getContent(), true);
  
      $updateBookRequestParams = [];
      $updateBookRequestParams['title'] =  $requestParams['title'] ?? null;
      $updateBookRequestParams['subtitle'] =  $requestParams['subtitle'] ?? null;
      $updateBookRequestParams['author'] =  $requestParams['author'] ?? null;
      $updateBookRequestParams['year'] =  $requestParams['year'] ?? null;
      $updateBookRequestParams['category'] =  $requestParams['category'] ?? null;
      $updateBookRequestParams['language'] =  $requestParams['language'] ?? null;
      $updateBookRequestParams['country'] =  $requestParams['country'] ?? null;
      $updateBookRequestParams['pages'] =  $requestParams['pages'] ?? null;
      $updateBookRequestParams['price'] =  $requestParams['price'] ?? null;
      $updateBookRequestParams['link'] =  $requestParams['link'] ?? null;
      $updateBookRequestParams['status'] =  $requestParams['status'] ?? null;
      $updateBookRequestParams['isbn'] =  $requestParams['isbn'] ?? null;
      $updateBookRequestParams['url'] =  $requestParams['url'] ?? null;
      $updateBookRequestParams['description'] =  $requestParams['description'] ?? null;
  
      $updateBookRequest = new UpdateBookRequest(
        $id,
        $updateBookRequestParams['title'],
        $updateBookRequestParams['subtitle'],
        $updateBookRequestParams['author'],
        $updateBookRequestParams['year'],
        $updateBookRequestParams['category'],
        $updateBookRequestParams['language'],
        $updateBookRequestParams['country'],
        $updateBookRequestParams['pages'],
        $updateBookRequestParams['price'],
        $updateBookRequestParams['link'],
        $updateBookRequestParams['status'],
        $updateBookRequestParams['isbn'],
        $updateBookRequestParams['url'],
        $updateBookRequestParams['description']
      );
  
      $book = $updateBookService->execute($updateBookRequest);
      $apiResponse->setData($book->__toArray());
    } catch (Exception $e) {
      $apiResponse->setError($e->getMessage(), $e->getCode());
    } catch (Error $e) {
      $apiResponse->setError($e->getMessage(), $e->getCode());
    }

    return $this->json($apiResponse->getApiResponse());
  }


  /**
   * @Route("books/{id}", name="book_delete", methods={"DELETE"})
   */
  public function delete(DeleteBookService $deleteBookService, int $id): Response
  {
      $apiResponse = new ApiResponse();

      try {
          $deleteBookRequest = new DeleteBookRequest($id);
          $deleteBookService->execute($deleteBookRequest);
      } catch (Exception $e) {
          $apiResponse->setError($e->getMessage(), $e->getCode());
      } catch (Error $e) {
          $apiResponse->setError($e->getMessage(), $e->getCode());
      }

      return $this->json($apiResponse->getApiResponse());
  }
}