<?php

namespace App\Controller\Admin;

use App\Entity\Disponibilite;
use App\Form\DisponibiliteType;
use App\Repository\DisponibiliteRepository;
use App\Repository\VehiculeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

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

    #[Route(path: '/create/{id}', name: 'create')]
    public function create(Request $request, EntityManagerInterface $em, VehiculeRepository $vehiculeRepository, $id)
    {
        $disponibilite = new Disponibilite();

        $form = $this->createForm(DisponibiliteType::class, $disponibilite);
        $form->handleRequest($request); // Pass the Request object here
        if ($form->isSubmitted() && $form->isValid()) {
            // Ici on recupere l'id de la voiture existants, pour qu'on pousse la disponibilité avec le bon id de voiture
            $vehicule = $vehiculeRepository->findVehiculeId($id);
            
            $disponibilite->setVehicule($vehicule);
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
}
