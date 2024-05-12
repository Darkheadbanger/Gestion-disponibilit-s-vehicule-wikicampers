<?php

namespace App\Controller\Admin;

use App\Form\RecipeType;
use App\Repository\CategoryRepository;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use Symfony\Component\HttpFoundation\Request;
// Use Class Recipe from entity Recipe.php
use App\Entity\Recipe;

#[Route('/admin/recettes', name: 'admin.recip.')]
class ReicipeController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(Request $request, RecipeRepository $repository, CategoryRepository $categoryRepository, EntityManagerInterface $em): Response
    {
        $recipes = $repository->findAll();
        // dd($recipes[1]->getCategory()->getName()); // PLat principlae
        // Ici pour afficher la somme des durées total
        // Donc on peut récuperer la function directement
        // dd($repository->findTotalDuration());
        // Ici pour modifier un titre
        // $recipes[0]->setTitle('Pâtes bolognaise');
        // $em->flush();
        // Ici pour chercher les recettes avec une durée inférieure à 20 minutes
        // $recipes = $repository->findWithDurationLowerThan(15);
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

        return $this->render('admin/reicipe/index.html.twig', [
            'recipes' => $recipes, 'controller_name' => 'ReicipeController',
        ]);
    }
    #[Route('/{slug}-{id}', name: 'show', requirements: ['id' => '\d+', "slug" => "[a-z0-9\-_]+"])]
    public function show(Request $request, string $slug, int $id, RecipeRepository $repository): Response
    {
        $recipe = $repository->find($id);
        if ($recipe->getSlug() !== $slug) {
            return $this->redirectToRoute("admin.reicipe.show", ["slug" => $recipe->getSlug(), 'id' => $recipe->getId()]);
        }
        return $this->render('admin/reicipe/show.html.twig', [
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

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Recipe $recipe, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $recipe->setCreatedAt(new \DateTimeImmutable());
            $recipe->setUpdatedAt(new \DateTimeImmutable());
            $em->flush();
            $this->addFlash('success', 'La recett a été modifiée avec succès');
            return $this->redirectToRoute('admin.recip.index');
        }
        // dd($recipe);
        return $this->render('admin/reicipe/edit.html.twig', [
            'controller_name' => 'ReicipeController',
            'recipe' => $recipe,
            'form' => $form,
        ]);
    }

    #[Route('/create', name: 'create')]
    public function create(Request $request, EntityManagerInterface $em, RecipeRepository $repository)
    {
        $recipe = new Recipe();
        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $existingRecipe = $repository->findTitleAndContent($recipe->getTitle(), $recipe->getContent());
            if ($existingRecipe) {
                $em->persist($recipe);
                $this->addFlash('danger', 'La recette existe déjà');
                return $this->redirectToRoute('admin.recip.index');
            }
            $recipe->setCreatedAt(new \DateTimeImmutable());
            $recipe->setUpdatedAt(new \DateTimeImmutable());
            $em->persist($recipe);
            $em->flush();
            $this->addFlash('success', 'La recette a été créée avec succès');
            return $this->redirectToRoute('admin.recip.index');
        }
        return $this->render('admin/reicipe/create.html.twig', [
            'controller_name' => 'ReicipeController',
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function remove(Recipe $recipe, EntityManagerInterface $em)
    {
        $em->remove($recipe);
        $em->flush();
        $this->addFlash('success', 'La recette a été supprimée avec succès');
        return $this->redirectToRoute('admin.recip.index');
    }
}
