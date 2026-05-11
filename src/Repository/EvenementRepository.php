<?php

namespace App\Repository;

use App\Entity\Evenement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Evenement>
 */
class EvenementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Evenement::class);
    }

    public function findByFiltres(
        ?string $recherche = null,
        ?string $gratuit = null
    ): array {
        $qb = $this->createQueryBuilder('e')
            ->where('e.dateDebut >= :now')
            ->setParameter('now', new \DateTimeImmutable())
            ->orderBy('e.dateDebut', 'ASC');

        if ($recherche) {
            $qb->andWhere('e.titre LIKE :q OR e.description LIKE :q OR e.adresse LIKE :q')
                ->setParameter('q', '%' . $recherche . '%');
        }

        if ($gratuit) {
            $qb->andWhere('e.estGratuit = true');
        }

        return $qb->getQuery()->getResult();
    }

    public function findByFiltresQuery(
        ?string $recherche = null,
        ?string $gratuit = null
    ): \Doctrine\ORM\Query {
        $qb = $this->createQueryBuilder('e')
            ->where('e.dateDebut >= :now')
            ->setParameter('now', new \DateTimeImmutable())
            ->orderBy('e.dateDebut', 'ASC');

        if ($recherche) {
            $qb->andWhere('e.titre LIKE :q OR e.description LIKE :q OR e.adresse LIKE :q')
               ->setParameter('q', '%' . $recherche . '%');
        }
        if ($gratuit) $qb->andWhere('e.estGratuit = true');

        return $qb->getQuery();
    }

    //    /**
    //     * @return Evenement[] Returns an array of Evenement objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('e.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Evenement
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
