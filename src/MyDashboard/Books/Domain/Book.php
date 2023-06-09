<?php

namespace App\MyDashboard\Books\Domain;

use App\MyDashboard\Shared\ValueObjects\BookCategory;
use App\MyDashboard\Shared\ValueObjects\Country;
use App\MyDashboard\Shared\ValueObjects\Language;
use App\MyDashboard\Shared\ValueObjects\Price;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=DoctrineBookRepository::class)
 */
class Book
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $subtitle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $author;

    /**
     * @ORM\Column(type="integer")
     */
    private $year;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $category;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $language;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $country;

    /**
     * @ORM\Column(type="integer")
     */
    private $pages;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $link;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $isbn;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $url;

    /**
     * @ORM\Column(type="string", length=600, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private ?\DateTimeInterface $createdAt = null;

    /**
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    private ?\DateTimeInterface $updatedAt = null;

    public function __construct(
        string $title,
        ?string $subtitle,
        string $author,
        int $year,
        ?BookCategory $category,
        Language $language,
        Country $country,
        int $pages,
        ?Price $price,
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
        $this->category = $category->getCategory();
        $this->language = $language->getCode();
        $this->country = $country->getCountry();
        $this->pages = $pages;
        $this->price = $price->getValue();
        $this->link = $link;
        $this->status = $status;
        $this->isbn = $isbn;
        $this->url = $url;
        $this->description = $description;
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
      }


    public function __toArray(): array
    {
        return [
            'id' => $this->getId(), 
            'title' => $this->getTitle(),
            'subtitle' => $this->getSubtitle(),
            'author' => $this->getAuthor(),
            'year' => $this->getYear(),
            'category' => $this->getCategory(),
            'language' => $this->getLanguage(),
            'country' => $this->getCountry(),
            'pages' => $this->getPages(),
            'price' => $this->getPrice(),
            'link' => $this->getLink(),
            'status' => $this->getStatus(),
            'isbn' => $this->getIsbn(),
            'url' => $this->getUrl(),
            'description' => $this->getDescription(),
            'createdAt' => $this->getCreatedAt(),
            'updatedAt' => $this->getUpdatedAt(),
        ];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSubtitle(): ?string
    {
        return $this->subtitle;
    }

    public function setSubtitle(?string $subtitle): self
    {
        $this->subtitle = $subtitle;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(?int $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(BookCategory $category): self
    {
        $this->category = $category->getCategory();

        return $this;
    }

    public function getLanguage(): string
    {
        return $this->language;
    }

    public function setLanguage(Language $language): self
    {
        $this->language = $language->getCode();

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(Country $country): self
    {
        $this->country = $country->getCountry();

        return $this;
    }

    public function getPages(): ?int
    {
        return $this->pages;
    }

    public function setPages(int $pages): self
    {
        $this->pages = $pages;

        return $this;
    }

    public function getPrice(): ?float
    {
        return round($this->price, 2);
    }

    public function setPrice(Price $price): self
    {
        $this->price = $price->getValue();

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getIsbn(): ?string
    {
        return $this->isbn;
    }

    public function setIsbn(?string $isbn): self
    {
        $this->isbn = $isbn;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }
}
