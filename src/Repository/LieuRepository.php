<?php

namespace App\Repository;

use App\Entity\Lieu;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Lieu>
 */
class LieuRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Lieu::class);
    }

    public function findByFiltres(?string $categorieSlug = null, ?string $recherche = null): array
    {
        $qb = $this->createQueryBuilder('l')
            ->leftJoin('l.categorie', 'c')
            ->addSelect('c')
            ->where('l.estValide = true')
            ->orderBy('l.createdAt', 'DESC');

        if ($categorieSlug) {
            $qb->andWhere('c.slug = :slug')
                ->setParameter('slug', $categorieSlug);
        }

        if ($recherche) {
            $qb->andWhere('l.titre LIKE :q OR l.description LIKE :q OR l.adresse LIKE :q')
                ->setParameter('q', '%' . $recherche . '%');
        }

        return $qb->getQuery()->getResult();
    }

    //    /**
    //     * @return Lieu[] Returns an array of Lieu objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('l.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Lieu
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
