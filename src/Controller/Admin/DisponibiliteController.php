<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route('/admin/category', name: 'admin.category.')]
class DisponibiliteController extends AbstractController
{

    // #[Route(path: '', name: 'index')]
    // public function index()
    // {
    // }

    // #[Route('/{slug}-{id}', name: 'show', requirements: ['id' => '\d+', "slug" => "[a-z0-9\-_]+"])]
    // public function show()
    // {
    // }

    // #[Route(path: '/create', name: 'create')]
    // public function create()
    // {
    // }

    // #[Route(path: '/id', name: 'edit', requirements: ['id' => Requirement::DIGITS])]
    // public function edit()
    // {
    // }

    // #[Route(path: '/{id}', name: 'delete')]
    // public function delete()
    // {
    // }
}
