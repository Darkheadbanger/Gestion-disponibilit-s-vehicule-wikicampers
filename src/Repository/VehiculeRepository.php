<?php

namespace App\Repository;

use App\Entity\Vehicule;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Vehicule>
 */
class VehiculeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vehicule::class);
    }

    public function findMarqueAndModele(string $marque, string $modele)
    {
        return $this->createQueryBuilder('r')
            ->where('r.marque = :marque AND r.modele = :modele')
            ->setParameter('marque', $marque)
            ->setParameter('modele', $modele)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findVehiculeId(int $id)
    {
        return $this->createQueryBuilder('v')
            ->where('v.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findByCriteria($dateDebut, $dateFin, $prixParJour)
    {
        $qb = $this->createQueryBuilder('v')
            ->join('v.disponibilities', 'd')
            ->where('d.dateDebut <= :dateDebut')
            ->andWhere('d.dateFin >= :dateFin')
            ->andWhere('d.prixParJour <= :prixParJour')
            ->setParameter('dateDebut', $dateDebut)
            ->setParameter('dateFin', $dateFin)
            ->setParameter('prixParJour', $prixParJour);

        return $qb->getQuery()->getResult();
    }

    //    /**
    //     * @return Vehicule[] Returns an array of Vehicule objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('v')
    //            ->andWhere('v.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('v.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Vehicule
    //    {
    //        return $this->createQueryBuilder('v')
    //            ->andWhere('v.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
