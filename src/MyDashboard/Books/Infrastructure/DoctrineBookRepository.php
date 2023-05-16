<?php

namespace App\MyDashboard\Books\Infrastructure;

use App\MyDashboard\Books\Domain\Book;
use App\MyDashboard\Books\Domain\BookRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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

    public function findByCriteria(Criteria $searchCriteria): ?array
    {
        $result = [
            'totalFound' => 0,
            'start' => 0,
            'size' => 0,
            'data' => []
        ];

        $queryBuilder = $this->entityManager
            ->createQueryBuilder()
            ->select('book')
            ->from('App\MyDashboard\Books\Domain\Book', 'book');

        // Join only entities/tables needed to improve performance
        $entitiesToJoin = [];

        if (strpos($searchCriteria->getOrder()->getOrderBy(), ".") !== false) {
            $entityToJoin = substr($searchCriteria->getOrder()->getOrderBy(), 0, strpos($searchCriteria->getOrder()->getOrderBy(), "."));
            if (!in_array($entityToJoin, $entitiesToJoin)) {
                $entitiesToJoin[] = substr($searchCriteria->getOrder()->getOrderBy(), 0, strpos($searchCriteria->getOrder()->getOrderBy(), "."));
            }
        }

        foreach ($searchCriteria->getFilterGroups() as $filters) {
            foreach ($filters as $filter) {
                if (strpos($filter->getField(), ".") !== false) {
                    $entityToJoin = substr($filter->getField(), 0, strpos($filter->getField(), "."));
                    if (!in_array($entityToJoin, $entitiesToJoin)) {
                        $entitiesToJoin[] = substr($filter->getField(), 0, strpos($filter->getField(), "."));
                    }
                }
            }
        }

        if (!empty($entitiesToJoin)) {
            $queryBuilder->distinct();
        }

        if ($searchCriteria->getAggregations()->count() > 0) {
            foreach ($searchCriteria->getAggregations() as $agg) {
                if (strpos($agg->getField(), ".") !== false) {
                    $entityToJoin = substr($agg->getField(), 0, strpos($agg->getField(), "."));
                    if (!in_array($entityToJoin, $entitiesToJoin)) {
                        $entitiesToJoin[] = substr($agg->getField(), 0, strpos($agg->getField(), "."));
                    }
                }
            }
        }

        $queryBuilder = (new CriteriaConverter($queryBuilder, 'book'))
            ->setCriteria($searchCriteria)
            ->convert();

        $query = $queryBuilder->getQuery();

        $results = $query->getResult();
        $start = $query->getFirstResult();
        $size = $query->getMaxResults();

        $paginator = new Paginator($query);

        $totalResults = $paginator->count();

        $result['data'] = $results;
        $result['start'] = $start;
        $result['size'] = $size;
        $result['totalFound'] = $totalResults;

        return $result;
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
