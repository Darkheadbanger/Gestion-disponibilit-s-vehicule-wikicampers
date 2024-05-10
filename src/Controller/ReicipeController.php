<?php

namespace App\Controller;

use App\Repository\RecipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

class ReicipeController extends AbstractController
{
    #[Route('/recettes', name: 'recip.index')]
    public function index(Request $request, RecipeRepository $repository): Response
    {
        $recipes = $repository->findAll();
        // $recipes = $repository->findWithDurationLowerThan(20);
        return $this->render('reicipe/index.html.twig', [
            'recipes' => $recipes, 'controller_name' => 'ReicipeController',
        ]);
    }
    #[Route('/recette/{slug}-{id}', name: 'recip.show', requirements: ['id' => '\d+', "slug" => "[a-z0-9\-_]+"])]
    public function show(Request $request, string $slug, int $id, RecipeRepository $repository): Response
    {
        $recipe = $repository->find($id);
        if ($recipe->getSlug() !== $slug) {
            return $this->redirectToRoute("recipe.show", ["slug" => $recipe->getSlug(), 'id' => $recipe->getId()]);
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
}
