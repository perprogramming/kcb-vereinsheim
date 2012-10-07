<?php

namespace Kcb\Bundle\VereinsheimBundle\Entity;

use Doctrine\ORM\EntityRepository;

class AnwesenderRepository extends EntityRepository {

    public function findOneByMitglied(Mitglied $mitglied) {
        $queryBuilder = $this->createQueryBuilder('a');
        $queryBuilder->andWhere('a.mitglied = :mitglied');
        $queryBuilder->setParameter('mitglied', $mitglied);
        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

}
