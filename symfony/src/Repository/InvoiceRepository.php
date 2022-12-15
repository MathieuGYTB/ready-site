<?php

namespace App\Repository;

use App\Entity\Invoice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Invoice>
 *
 * @method Invoice|null find($id, $lockMode = null, $lockVersion = null)
 * @method Invoice|null findOneBy(array $criteria, array $orderBy = null)
 * @method Invoice[]    findAll()
 * @method Invoice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InvoiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Invoice::class);
    }

    public function save(Invoice $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Invoice $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    public function findPdfFromInvoice(Invoice $invoice): ?Invoice
//    {
//        $user = $this->getUser();
//        return $this->createQueryBuilder('i')
//            ->select('i, u')
//            ->leftJoin('i.user', 'd')
//            ->setParameter('pdf', $invoice->getPdf())
//            ->setMaxResults(1)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
//    public function findOneBySomeField($value): ?Invoice
//        {
//            return $this->createQueryBuilder('i')
//                ->andWhere('i.exampleField = :val')
//                ->setParameter('val', $value)
//                ->getQuery()
//                ->getOneOrNullResult()
//            ;
//        }
        public function findPdfFromInvoice(string $invoice): array
        {
            $conn = $this->getEntityManager()->getConnection();

            $sql = '
                SELECT i, u 
                FROM App\Entity\Invoice i
                LEFT JOIN i.user u
                ON i.user = u.id
                ';
            $stmt = $conn->prepare($sql);
            $resultSet = $stmt->executeQuery(['invoice' => $invoice]);

          // returns an array of arrays (i.e. a raw data set)
            return $resultSet->fetchAllAssociative();
        }
}
