<?php

namespace App\Repository;

use App\Entity\Vehicule;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Vehicule>
 * 
 * Le repository pour l'entité Vehicule.
 */
class VehiculeRepository extends ServiceEntityRepository
{
    /**
     * Constructeur du repository, initialise le repository avec le manager des entités.
     *
     * @param ManagerRegistry $registry Le registre des gestionnaires d'entités.
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vehicule::class);
    }

    /**
     * Trouve un véhicule par sa marque et son modèle.
     *
     * @param string $marque La marque du véhicule.
     * @param string $modele Le modèle du véhicule.
     * @return Vehicule|null Retourne le véhicule trouvé ou null.
     */
    public function findMarqueAndModele(string $marque, string $modele)
    {
        return $this->createQueryBuilder('r')
            ->where('r.marque = :marque AND r.modele = :modele')
            ->setParameter('marque', $marque)
            ->setParameter('modele', $modele)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Trouve un véhicule par son identifiant.
     *
     * @param int $id L'identifiant du véhicule.
     * @return Vehicule|null Retourne le véhicule trouvé ou null.
     */
    public function findVehiculeId(int $id)
    {
        return $this->createQueryBuilder('v')
            ->where('v.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Trouve des véhicules selon des critères spécifiques.
     *
     * @param string $dateDebut La date de début de la disponibilité.
     * @param string $dateFin La date de fin de la disponibilité.
     * @param float $prixParJour Le prix maximum par jour.
     * @return Vehicule[] Retourne un tableau de véhicules correspondant aux critères.
     */
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

    // Méthodes exemples commentées :

    // /**
    //  * @return Vehicule[] Retourne un tableau d'objets Vehicule
    //  */
    // public function findByExampleField($value): array
    // {
    //     return $this->createQueryBuilder('v')
    //         ->andWhere('v.exampleField = :val')
    //         ->setParameter('val', $value)
    //         ->orderBy('v.id', 'ASC')
    //         ->setMaxResults(10)
    //         ->getQuery()
    //         ->getResult()
    //     ;
    // }

    // /**
    //  * Trouve un véhicule par un champ spécifique.
    //  *
    //  * @param mixed $value La valeur à rechercher.
    //  * @return Vehicule|null Retourne le véhicule trouvé ou null.
    //  */
    // public function findOneBySomeField($value): ?Vehicule
    // {
    //     return $this->createQueryBuilder('v')
    //         ->andWhere('v.exampleField = :val')
    //         ->setParameter('val', $value)
    //         ->getQuery()
    //         ->getOneOrNullResult()
    //     ;
    // }
}
