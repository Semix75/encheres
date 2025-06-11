<?php

namespace App\Repository;

use App\Entity\Enchere;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Enchere>
 */
class EnchereRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Enchere::class);
    }

    /**
     * Récupère les enchères terminées (dateFin passée)
     *
     * @return Enchere[]
     */
    public function findEncheresTerminees(): array
    {
        return $this->createQueryBuilder('e')
            ->where('e.dateFin < :now')
            ->setParameter('now', new \DateTimeImmutable())
            ->orderBy('e.dateFin', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
