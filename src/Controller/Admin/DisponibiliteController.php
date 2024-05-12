<?php

namespace App\Controller\Admin;

use App\Entity\Disponibilite;
use App\Form\CategoryType;
use App\Repository\DisponibiliteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route('/admin/disponibilite', name: 'admin.disponibilite.')]
class DisponibiliteController extends AbstractController
{

    #[Route(path: '/', name: 'index')]
    public function index(DisponibiliteRepository $repository)
    {
        return $this->render('admin/disponibilite/index.html.twig', [
            'controller_name' => 'DisponibiliteController',
            'disponibilites' => $repository->findAll(),
        ]);
    }

    #[Route(path: '/create', name: 'create')]
    public function create(Request $request, EntityManagerInterface $em)
    {
        $disponibilite = new Disponibilite();
        $form = $this->createForm(CategoryType::class, $disponibilite);
        $form->handleRequest($request); // Pass the Request object here
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($disponibilite);
            $em->flush();
            $this->addFlash('success', 'La disponibilitée a été créée avec succès');
            return $this->redirectToRoute('admin.vehicule.index');
        }
        return $this->render('admin/disponibilite/create.html.twig', [
            'controller_name' => 'DisponibiliteController',
            'form' => $form,
        ]);
    }

    // #[Route(path: '/{id}', name: 'edit', requirements: ['id' => Requirement::DIGITS], methods: ['GET', 'POST'])]
    // public function edit(Disponibilite $disponibilite, Request $request, EntityManagerInterface $em)
    // {
    //     // $disponibilite = new Disponibilite();
    //     $form = $this->createForm(CategoryType::class, $disponibilite);
    //     $form->handleRequest($request);
    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $em->flush();
    //         $this->addFlash('success', 'La disponibilité a été modifié avec succès');
    //         return $this->redirectToRoute('admin.vehicule.index');
    //     }
    //     return $this->render('admin/disponibilite/create.html.twig', [
    //         'controller_name' => 'DisponibiliteController',
    //         'disponibilite' => $disponibilite,
    //         'form' => $form,
    //     ]);
    // }

    // #[Route(path: '/{id}', name: 'delete', methods: 'DELETE')]
    // public function delete(Disponibilite $disponibilite, Request $request, EntityManagerInterface $em)
    // {
    //     $em->remove($disponibilite);
    //     $em->flush();
    //     $this->addFlash('success', 'La catégorie a été supprimée avec succès');
    //     return $this->redirectToRoute('admin.vehicule.index');
    // }
}
