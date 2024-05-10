<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

use App\Repository\DisponibiliteRepository;

class DisponibiliteController extends AbstractController
{
    #[Route('/disponibilite', name: 'disponibilite.index')]
    public function index(Request $request, DisponibiliteRepository $repository, EntityManagerInterface $em): Response
    {
        // $recipes = $repository->findAll();
        // Ici pour afficher la somme des durées total
        // Donc on peut récuperer la function directement
        // dd($repository->findTotalDuration());
        // Ici pour modifier un titre
        // $recipes[0]->setTitle('Pâtes bolognaise');
        // $em->flush();
        // Ici pour chercher les recettes avec une durée inférieure à 20 minutes
        $recipes = $repository->findWithDurationLowerThan(15);
        // Ici pour ajouter une recette
        // $recipe = new Recipe();
        // $recipe->setTitle('Barbe à papa')
        //     ->setSlug('barbe-a-papa')
        //     ->setContent('Dessert')
        //     ->setCreatedAt(new \DateTimeImmutable())
        //     ->setUpdatedAt(new \DateTimeImmutable())
        //     ->setDuration("2 Minutes");
        // $em->persist($recipe);
        // $em->flush();
        // Ici pour supprimer une recette
        // $em->remove($recipes[0]);
        // $em->flush();
        return $this->render('disponibilite/index.html.twig', [
            'controller_name' => 'DisponibiliteController',
        ]);
    }

    #[Route('/disponibilite/{slug}-{id}', name: 'disponibilite.show', requirements: ['id' => '\d+', "slug" => "[a-z0-9\-_]+"])]
    public function show(Request $request, string $slug, int $id, DisponibiliteRepository $repository)
    {
        // $recipe = $repository->find($id);
        // if ($recipe->getSlug() !== $slug) {
        //     return $this->redirectToRoute("recipe.show", ["slug" => $recipe->getSlug(), 'id' => $recipe->getId()]);
        // }
        // return $this->render('reicipe/show.html.twig', [
        //     'controller_name' => 'ReicipeController',
        //     // 'slug' => $slug,
        //     // 'demo' => '<strong>demo</strong>',
        //     // 'id' => $id,
        //     // 'person' => [
        //     //     'name' => 'John',
        //     //     'age' => 25
        //     // ],
        //     'recipe' => $recipe,
        // ]);
    }


}
