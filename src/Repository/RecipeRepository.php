<?php

namespace App\Repository;

use App\Entity\Recipe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
class RecipeRepository extends ServiceEntityRepository
{
    public function __construct()
    {
    }

}
