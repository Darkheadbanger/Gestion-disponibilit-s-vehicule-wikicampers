<?php

namespace App\Controller\Admin;

use App\Form\VehiculeType;
use App\Repository\RecipeRepository;
use App\Repository\VehiculeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Vehicule;

#[Route('/admin/vehicules', name: 'admin.vehicule.')]
class VehiculeController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(VehiculeRepository $repository): Response
    {
        $vehicules = $repository->findAll();
        return $this->render(
            'admin/vehicule/index.html.twig',
            [
                'vehicules' => $vehicules,
                'controller_name' => 'VehiculeController'
            ]
        );
    }

    #[Route('/{slug}-{id}', name: 'show', requirements: ['id' => '\d+', "slug" => "[a-z0-9\-_]+"])]
    public function show(Request $request, string $slug, int $id, VehiculeRepository $repository): Response
    {
        $vehicule = $repository->find($id);
        // if ($vehicule->getSlug() !== $slug) {
        //     return $this->redirectToRoute("admin.vehicule.show", ["slug" => $vehicule->getSlug(), 'id' => $vehicule->getId()]);
        // }
        return $this->render('admin/vehicule/show.html.twig', [
            'controller_name' => 'VehiculeController',
            'vehicule' => $vehicule,
        ]);
    }

    // Ici la route pour editer un vehicule
    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Vehicule $vehicule, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(VehiculeType::class, $vehicule);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $vehicule->setCreatedAt(new \DateTimeImmutable());
            // $vehicule->setUpdatedAt(new \DateTimeImmutable());
            $em->flush();
            $this->addFlash('success', 'La voiture a été modifiée avec succès');
            return $this->redirectToRoute('admin.vehicule.index');
        }
        // dd($recipe);
        return $this->render('admin/vehicule/edit.html.twig', [
            'controller_name' => 'VehiculeController',
            'vehicule' => $vehicule,
            'form' => $form,
        ]);
    }

    #[Route('/create', name: 'create')]
    public function create(Request $request, EntityManagerInterface $em, VehiculeRepository $repository): Response
    {
        $vehicule = new Vehicule();
        $form = $this->createForm(VehiculeType::class, $vehicule);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $existingRecipe = $repository->findMarqueAndModele($vehicule->getMarque(), $vehicule->getModele());
            if ($existingRecipe) {
                $em->persist($vehicule);
                $this->addFlash('danger', 'La voiture existe déjà');
                return $this->redirectToRoute('admin.vehicule.index');
            }
            // $vehicul->setCreatedAt(new \DateTimeImmutable());
            // $vehicul->setUpdatedAt(new \DateTimeImmutable());
            $em->persist($vehicule);
            $em->flush();
            $this->addFlash('success', 'La vehicule a été créée avec succès');
            return $this->redirectToRoute('admin.vehicule.index');
        }
        return $this->render('admin/vehicule/create.html.twig', [
            'controller_name' => 'VehiculeController',
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function remove(Request $request, Vehicule $vehicule, EntityManagerInterface $em): Response
    {
        $em->remove($vehicule);
        $em->flush();
        $this->addFlash('success', 'La recette a été supprimée avec succès');
        return $this->redirectToRoute('admin.vehicule.index');
    }
}
