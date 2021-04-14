<?php

namespace Gslim\App\Repository;

use Gslim\App\Entity\MasterToken;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;


class MasterTokenRepository extends EntityRepository
{

    public function findByField($value)
    {
        return $this->getEntityManager()
            ->getRepository(MasterToken::class)
            ->createQueryBuilder('a')
            ->andWhere('a.id < :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->getQuery()
            ->getArrayResult();
    }

}
