<?php

namespace App\MyDashboard\Books\Application;

use App\MyDashboard\Books\Domain\BookRepositoryInterface;
use App\MyDashboard\Shared\Domain\ValueObject\BookCategory;
use App\MyDashboard\Shared\Domain\ValueObject\Country;
use App\MyDashboard\Shared\Domain\ValueObject\Language;
use App\MyDashboard\Shared\Domain\ValueObject\Price;
use Exception;

class UpdateBookService
{
  protected $bookRepository;

  public function __construct(BookRepositoryInterface $bookRepository)
  {
    $this->bookRepository = $bookRepository;
  }

  public function execute(UpdateBookRequest $updateBookRequest)
  {
    $book = $this->bookRepository->findOneBy(['id' => $updateBookRequest->getId()]);

    if ($book === null) {
      throw new Exception("Book not found");
    }

    $title = $updateBookRequest->getTitle();
    if ($title !== null && $title !== '') {
      $book->setTitle($title);
    }

    $subtitle = $updateBookRequest->getSubtitle();
    if ($subtitle !== null && $subtitle !== '') {
      $book->setSubtitle($subtitle);
    }

    $author = $updateBookRequest->getAuthor();
    if ($author !== null && $author !== '') {
      $book->setAuthor($author);
    }

    $year = $updateBookRequest->getYear();
    if ($year !== null) {
      $book->setYear($year);
    }

    $category = $updateBookRequest->getCategory();
    if ($category !== null && $category !== '') {
      $book->setCategory(new BookCategory($category));
    }

    $language = $updateBookRequest->getLanguage();
    if ($language !== null && $language !== '') {
      $book->setLanguage(new Language($language));
    }

    $country = $updateBookRequest->getCountry();
    if ($country !== null && $country !== '') {
      $book->setCountry(new Country($country));
    }

    $pages = $updateBookRequest->getPages();
    if ($pages !== null) {
      $book->setPages($pages);
    }

    $price = $updateBookRequest->getPrice();
    if ($price !== null) {
      $book->setPrice(new Price($price));
    }

    $link = $updateBookRequest->getLink();
    if ($link !== null && $link !== '') {
      $book->setLink($link);
    }

    $status = $updateBookRequest->getStatus();
    if ($status !== null && $status !== '') {
      $book->setStatus($status);
    }

    $isbn = $updateBookRequest->getIsbn();
    if ($isbn !== null && $isbn !== '') {
      $book->setIsbn($isbn);
    }

    $url = $updateBookRequest->getUrl();
    if ($url !== null && $url !== '') {
      $book->setUrl($url);
    }

    $description = $updateBookRequest->getDescription();
    if ($description !== null && $description !== '') {
      $book->setDescription($description);
    }

    $this->bookRepository->save($book);

    return $book;
  }
}
