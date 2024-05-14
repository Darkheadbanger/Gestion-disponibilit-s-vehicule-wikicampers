<?php

namespace App\Controller\Admin;

use App\Entity\Disponibilite;
use App\Form\DisponibiliteType;
use App\Repository\DisponibiliteRepository;
use App\Repository\VehiculeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/disponibilite', name: 'admin.disponibilite.')]
class DisponibiliteController extends AbstractController
{
    // Route pour afficher toutes les disponibilités
    #[Route(path: '/', name: 'index')]
    public function index(DisponibiliteRepository $repository)
    {
        // Récupère toutes les disponibilités du repository et les passe à la vue
        return $this->render('admin/disponibilite/index.html.twig', [
            'controller_name' => 'DisponibiliteController',
            'disponibilites' => $repository->findAll(),
        ]);
    }

    // Route pour créer une nouvelle disponibilité
    #[Route(path: '/create/{id}', name: 'create')]
    public function create(Request $request, EntityManagerInterface $em, VehiculeRepository $vehiculeRepository, $id)
    {
        // Crée une nouvelle instance de Disponibilite
        $disponibilite = new Disponibilite();

        // Crée le formulaire pour la disponibilité
        $form = $this->createForm(DisponibiliteType::class, $disponibilite);
        $form->handleRequest($request);

        // Vérifie si le formulaire a été soumis et est valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupère le véhicule existant par son ID
            $vehicule = $vehiculeRepository->find($id);

            // Vérifie si le véhicule existe
            if (!$vehicule) {
                throw $this->createNotFoundException('Le véhicule avec l\'ID ' . $id . ' n\'existe pas.');
            }

            // Associe le véhicule à la disponibilité
            $disponibilite->setVehicule($vehicule);

            // Persiste la disponibilité dans la base de données
            $em->persist($disponibilite);
            $em->flush();

            // Ajoute un message de succès et redirige vers la liste des véhicules
            $this->addFlash('success', 'La disponibilité a été créée avec succès');
            return $this->redirectToRoute('admin.vehicule.index');
        }

        // Affiche le formulaire de création de disponibilité
        return $this->render('admin/disponibilite/create.html.twig', [
            'controller_name' => 'DisponibiliteController',
            'form' => $form,
        ]);
    }
}
