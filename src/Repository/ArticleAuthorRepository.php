<?php

namespace App\Repository;

use App\Entity\ArticleAuthor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ArticleAuthor>
 *
 * @method ArticleAuthor|null find($id, $lockMode = null, $lockVersion = null)
 * @method ArticleAuthor|null findOneBy(array $criteria, array $orderBy = null)
 * @method ArticleAuthor[]    findAll()
 * @method ArticleAuthor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleAuthorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ArticleAuthor::class);
    }

//    /**
//     * @return ArticleAuthor[] Returns an array of ArticleAuthor objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ArticleAuthor
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
