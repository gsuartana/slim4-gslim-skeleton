<?php

namespace Gslim\App\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping;

class ErrorRepository extends EntityRepository
{


    public function queryGetErrorRepositorys()
    {
        return $this->getEntityManager()->createQueryBuilder()
            ->getQuery()
            ->getResult();
    }


}
