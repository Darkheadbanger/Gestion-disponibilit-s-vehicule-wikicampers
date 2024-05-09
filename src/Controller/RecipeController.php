<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RecipeController extends AbstractController
{
    // Requirement permet de préciser les contraintes sur les paramètres
    // #[Route('/recette/{slug}-{id}', name: 'recipe.show', requirements: ['slug' => '[a-z0-9\-]+', 'id' => '\d+'])]
    // public function index(Request $request, string $slug, int $id): Response
    // {
    //     // On peut faire cela
    //     // dd($request->attributes->get('slug'), $request->attributes->getInt("id"));
    //     // Si non, cette manièr mais il faut préciser dans le paramtre
    //     dd($slug, $id);
    // } 
    #[Route('/recette', name: 'recipe.index')]
    public function index(Request $request): Response
    {
        return new Response("Recettes");
    }

    #[Route('/recette/{slug}-{id}', name: 'recipe.show', requirements: ['slug' => '[a-z0-9\-]+', 'id' => '\d+'])]
    public function show(Request $request, string $slug, int $id): Response
    {
        return new Response("Recette :" . $slug . " " . $id);
        // Ou
        // return $this->json(["slug" => $slug, "id" => $id]);

        // Retourner JSON
    }
}
