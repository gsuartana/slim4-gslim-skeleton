<?php

namespace Gslim\App\Repository;

use Doctrine\ORM\EntityRepository;

class PregReplace extends EntityRepository
{
    public function queryGetPregReplaces()
    {
        return $this->createQueryBuilder()
            ->getQuery()
            ->getResult();
    }

    /*
   public function findByExampleField($value)
   {
       return $this->createQueryBuilder('a')
           ->andWhere('a.exampleField = :val')
           ->setParameter('val', $value)
           ->orderBy('a.id', 'ASC')
           ->setMaxResults(10)
           ->getQuery()
           ->getResult()
       ;
   }
   */

    /*
    public function findOneBySomeField($value): ?Article
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
