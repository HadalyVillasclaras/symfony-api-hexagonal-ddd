<?php

  namespace App\MyDashboard\Books\Application;

use DateTime;

  class UpdateBookRequest
  {
    private $id;
    private $title;
    private $subtitle;
    private $author;
    private $year;
    private $category;
    private $language;
    private $country;
    private $pages;
    private $price;
    private $link;
    private $status;
    private $isbn;
    private $url;
    private $description;

    public function __construct(
      ?int $id,
      ?string $title,
      ?string $subtitle,
      ?string $author,
      ?string $year,
      ?string $category,
      ?string $language,
      ?string $country,
      ?int $pages,
      ?float $price,
      ?string $link,
      ?string $status,
      ?string $isbn,
      ?string $url,
      ?string $description

    ) {

      $this->title = $title;
      $this->subtitle = $subtitle;
      $this->author = $author;
      $this->year = $year;
      $this->category = $category;
      $this->language = $language;
      $this->country = $country;
      $this->pages = $pages;
      $this->price = $price;
      $this->link = $link;
      $this->status = $status;
      $this->isbn = $isbn;
      $this->url = $url;
      $this->description = $description;

    }

    public function getId(): ?int
    {
        return $this->id;
    }
   
    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getSubtitle(): ?string
    {
        return $this->subtitle;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function getYear(): ?string
    {
        return $this->year;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function getPages(): ?int
    {
        return $this->pages;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function getIsbn(): ?string
    {
        return $this->isbn;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }
  }