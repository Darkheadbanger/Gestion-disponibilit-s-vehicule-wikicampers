<?php
// Ce Repository est inutile, mais sa suppression génère des erreurs sur le frontend.
namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class CategoryRepository extends ServiceEntityRepository
{
    public function __construct()
    {
    }
}
