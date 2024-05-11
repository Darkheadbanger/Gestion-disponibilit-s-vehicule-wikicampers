<?php

namespace App\Controller;

use App\Form\RecipeType;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use Symfony\Component\HttpFoundation\Request;
// Use Class Recipe from entity Recipe.php
use App\Entity\Recipe;

class ReicipeController extends AbstractController
{
    #[Route('/recettes', name: 'recip.index')]
    public function index(Request $request, RecipeRepository $repository, EntityManagerInterface $em): Response
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

        return $this->render('reicipe/index.html.twig', [
            'recipes' => $recipes, 'controller_name' => 'ReicipeController',
        ]);
    }
    #[Route('/recette/{slug}-{id}', name: 'recip.show', requirements: ['id' => '\d+', "slug" => "[a-z0-9\-_]+"])]
    public function show(Request $request, string $slug, int $id, RecipeRepository $repository): Response
    {
        $recipe = $repository->find($id);
        if ($recipe->getSlug() !== $slug) {
            return $this->redirectToRoute("reicipe.show", ["slug" => $recipe->getSlug(), 'id' => $recipe->getId()]);
        }
        return $this->render('reicipe/show.html.twig', [
            'controller_name' => 'ReicipeController',
            // 'slug' => $slug,
            // 'demo' => '<strong>demo</strong>',
            // 'id' => $id,
            // 'person' => [
            //     'name' => 'John',
            //     'age' => 25
            // ],
            'recipe' => $recipe,
        ]);
    }

    #[Route('/recettes/{id}/edit', name: 'recip.edit')]
    public function edit(Recipe $recipe, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success','La recett a été modifiée avec succès');
            return $this->redirectToRoute('recip.index');
        }
        // dd($recipe);
        return $this->render('reicipe/edit.html.twig', [
            'controller_name' => 'ReicipeController',
            'recipe' => $recipe,
            'form' => $form,
        ]);

    }
}
