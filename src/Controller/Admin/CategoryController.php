<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

use Symfony\Component\Routing\Requirement\Requirement;

#[Route('/admin/category', name: 'admin.category.')]
class CategoryController extends AbstractController
{

    #[Route(path: '/', name: 'index')]
    public function index(CategoryRepository $repository)
    {
        return $this->render('admin/category/index.html.twig', [
            'controller_name' => 'CategoryController',
            'categories' => $repository->findAll(),
        ]);
    }

    #[Route(path: '/create', name: 'create')]
    public function create(Request $request, EntityManagerInterface $em)
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request); // Pass the Request object here
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($category);
            $em->flush();
            $this->addFlash('success', 'La catégorie a été créée avec succès');
            return $this->redirectToRoute('admin.category.index');
        }
        return $this->render('admin/category/create.html.twig', [
            'controller_name' => 'CategoryController',
            'form' => $form,
        ]);
    }
    #[Route(path: '/id', name: 'edit', requirements: ['id' => Requirement::DIGITS], methods: ['GET', 'POST'])]
    public function edit(Category $category, Request $request, EntityManagerInterface $em)
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'La catégorie a été modifié avec succès');
            return $this->redirectToRoute('admin.category.index');
        }
        return $this->render('admin/category/create.html.twig', [
            'controller_name' => 'CategoryController',
            'category' => $category,
            'form' => $form,
        ]);
    }

    #[Route(path: '/{id}', name: 'delete', methods: 'DELETE')]
    public function delete(Category $category, Request $request, EntityManagerInterface $em)
    {
        $em->remove($category);
        $em->flush();
        $this->addFlash('success', 'La catégorie a été supprimée avec succès');
        return $this->redirectToRoute('admin.category.index');
    }
}
