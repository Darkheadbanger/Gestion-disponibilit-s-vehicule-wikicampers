<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

class ReicipeController extends AbstractController
{
    #[Route('/recettes', name: 'recip.index')]
    public function index(Request $request): Response
    {
        return $this->render('reicipe/index.html.twig', [
            'controller_name' => 'ReicipeController',
        ]);
    }
    #[Route('/recette/{slug}-{id}', name: 'recip.show', requirements: ['id' => '\d+', "slug" => "[a-z0-9\-]+"])]
    public function show(Request $request, string $slug, int $id): Response
    {
        return $this->render('reicipe/show.html.twig', [
            'controller_name' => 'ReicipeController',
            'slug' => $slug,
            'demo' => '<strong>demo</strong>',
            'id' => $id,
            'person' => [
                'name' => 'John',
                'age' => 25
            ]
        ]);
    }
}
