<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ReicipeController extends AbstractController
{
    #[Route('/reicipe', name: 'app_reicipe')]
    public function index(): Response
    {
        return $this->render('reicipe/index.html.twig', [
            'controller_name' => 'ReicipeController',
        ]);
    }
}
