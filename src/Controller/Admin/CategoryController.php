<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Routing\Attribute\Route;

use Symfony\Component\Routing\Requirement\Requirement;

#[Route('/admin/category', name: 'admin.category.')]

class CategoryController extends AbstractController

{

    #[Route(path: '', name: 'index')]

    public function index()

    {
    }

    #[Route(path: '/create', name: 'create')]

    public function create()

    {
    }

    #[Route(path: '/id', name: 'edit', requirements: ['id' => Requirement::DIGITS], methods: ['GET', 'POST'])]

    public function edit()

    {
    }

    #[Route(path: '/{id}', name: 'delete', methods: 'DELETE')]

    public function delete()

    {
    }
}
