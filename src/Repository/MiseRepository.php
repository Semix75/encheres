<?php

namespace App\Repository;

use App\Entity\Mise;
use App\Entity\Enchere;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Mise>
 */
class MiseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Mise::class);
    }

    /**
     * Trouve la mise gagnante d'une enchère inversée :
     * - La plus petite mise
     * - Proposée une seule fois
     */
    public function trouverGagnant(Enchere $enchere): ?Mise
    {
        // Étape 1 : Récupère le plus petit montant unique
        $conn = $this->getEntityManager()->getConnection();
        $sql = "
            SELECT montant
            FROM mise
            WHERE enchere_id = :enchere_id
            GROUP BY montant
            HAVING COUNT(*) = 1
            ORDER BY montant ASC
            LIMIT 1
        ";

        $montant = $conn->fetchOne($sql, ['enchere_id' => $enchere->getId()]);

        if (!$montant) {
            return null; // Aucun gagnant
        }

        // Étape 2 : Retourne l'objet Mise correspondant à ce montant
        return $this->createQueryBuilder('m')
            ->where('m.enchere = :enchere')
            ->andWhere('m.montant = :montant')
            ->setParameter('enchere', $enchere)
            ->setParameter('montant', $montant)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
