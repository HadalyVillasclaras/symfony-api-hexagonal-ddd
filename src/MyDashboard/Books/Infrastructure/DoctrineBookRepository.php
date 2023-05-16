<?php

namespace App\MyDashboard\Books\Infrastructure;

use App\MyDashboard\Books\Domain\Book;
use App\MyDashboard\Books\Domain\BookRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Book>
 *
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DoctrineBookRepository extends ServiceEntityRepository implements BookRepositoryInterface
{
    private $entityManager;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
        $this->entityManager = $this->getEntityManager();
    }

    public function findAll(): ?array
    {
        return parent::findAll();
    }

    public function save(Book $book): void
    {
        $this->entityManager->persist($book);
        $this->entityManager->flush();
    }


    public function add(Book $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Book $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function delete(Book $book): void
    {
        $this->entityManager->remove($book);
        $this->entityManager->flush();
    }

    public function findByCriteria(array $criteria, int $limit = 10, int $offset = 0): array
    {
        $qb = $this->createQueryBuilder('b');

        foreach ($criteria as $field => $value) {
            $qb->andWhere('b.' . $field . ' LIKE :' . $field)
                ->setParameter($field, '%' . $value . '%');
        }

        $query = $qb->getQuery();
        $paginator = new Paginator($query);

        $totalItems = count($paginator);
        $pagesCount = ceil($totalItems / $limit);

        $paginator
            ->getQuery()
            ->setFirstResult($offset)
            ->setMaxResults($limit);

        $books = [];
        foreach ($paginator as $book) {
            $books[] = $book;
        }

        return [
            "totalFound" => $totalItems,
            "limit" => $limit,
            "data" => $books
        ];
    }

    //    /**
    //     * @return Book[] Returns an array of Book objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('b.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Book
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
