<?php

namespace App\Repository;

use App\Entity\Terrain;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Terrain>
 */
class TerrainRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Terrain::class);
    }

    public function findByFiltres(
        ?string $recherche = null,
        ?string $douche = null,
        ?string $electricite = null,
        ?string $wifi = null,
        ?string $gratuit = null
    ): array {
        $qb = $this->createQueryBuilder('t')
            ->where('t.estDisponible = true')
            ->orderBy('t.createdAt', 'DESC');

        if ($recherche) {
            $qb->andWhere('t.titre LIKE :q OR t.description LIKE :q OR t.adresse LIKE :q')
               ->setParameter('q', '%' . $recherche .'%');
        }
        if ($douche) {
            $qb->andWhere('t.aDouche = true');
        }
        if ($electricite) {
            $qb->andWhere('t.aElectricite = true');
        }
        if ($wifi) {
        $qb->andWhere('t.aWifi = true');
    }
    if ($gratuit) {
        $qb->andWhere('t.prixNuit IS NULL');
    }

    return $qb->getQuery()->getResult();
    }

    public function findByFiltresQuery(
        ?string $recherche = null,
        ?string $douche = null,
        ?string $electricite = null,
        ?string $wifi = null,
        ?string $gratuit = null
    ): \Doctrine\ORM\Query {
        $qb = $this->createQueryBuilder('t')
            ->where('t.estDisponible = true')
            ->orderBy('t.createdAt', 'DESC');

        if ($recherche) {
            $qb->andWhere('t.titre LIKE :q OR t.description LIKE :q OR t.adresse LIKE :q')
               ->setParameter('q', '%' . $recherche . '%');
        }
        if ($douche) $qb->andWhere('t.aDouche = true');
        if ($electricite) $qb->andWhere('t.aElectricite = true');
        if ($wifi) $qb->andWhere('t.aWifi = true');
        if ($gratuit) $qb->andWhere('t.prixNuit IS NULL');

        return $qb->getQuery();
    }

    //    /**
    //     * @return Terrain[] Returns an array of Terrain objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Terrain
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
