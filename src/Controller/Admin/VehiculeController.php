<?php

namespace App\Controller\Admin;

use App\Entity\Disponibilite;
use App\Form\VehiculeType;
use App\Form\SearchType;
use App\Repository\VehiculeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Vehicule;
use App\Repository\DisponibiliteRepository;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route('/admin/vehicules', name: 'admin.vehicule.')]
class VehiculeController extends AbstractController
{
    // Route pour afficher tous les véhicules
    #[Route('/', name: 'index')]
    public function index(VehiculeRepository $repository, EntityManagerInterface $em, DisponibiliteRepository $repositoryDisponibilite): Response
    {
        // Récupère tous les véhicules du repository
        $vehicules = $repository->findAll();
        return $this->render(
            'admin/vehicule/index.html.twig',
            [
                'vehicules' => $vehicules,
                'controller_name' => 'VehiculeController'
            ]
        );
    }

    // Route pour afficher les détails d'un véhicule
    #[Route('/{slug}-{id}', name: 'show', requirements: ['id' => '\d+', "slug" => "[a-z0-9\-_]+"])]
    public function show(Request $request, string $slug, int $id, VehiculeRepository $repository): Response
    {
        // Récupère le véhicule par son ID
        $vehicule = $repository->find($id);
        return $this->render('admin/vehicule/show.html.twig', [
            'controller_name' => 'VehiculeController',
            'vehicule' => $vehicule,
        ]);
    }

    // Route pour éditer un véhicule
    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'], requirements: ['id' => Requirement::DIGITS])]
    public function edit(Vehicule $vehicule, Request $request, EntityManagerInterface $em): Response
    {
        // Crée le formulaire pour éditer le véhicule
        $form = $this->createForm(VehiculeType::class, $vehicule);
        $form->handleRequest($request);

        // Vérifie si le formulaire a été soumis et est valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Enregistre les modifications du véhicule
            $em->flush();
            $this->addFlash('success', 'La voiture a été modifiée avec succès');
            return $this->redirectToRoute('admin.vehicule.index');
        }

        return $this->render('admin/vehicule/edit.html.twig', [
            'controller_name' => 'VehiculeController',
            'vehicule' => $vehicule,
            'form' => $form,
        ]);
    }

    // Route pour créer un nouveau véhicule
    #[Route('/create', name: 'create')]
    public function create(Request $request, EntityManagerInterface $em, VehiculeRepository $repository): Response
    {
        // Crée une nouvelle instance de Vehicule
        $vehicule = new Vehicule();

        // Crée le formulaire pour le véhicule
        $form = $this->createForm(VehiculeType::class, $vehicule);
        $form->handleRequest($request);

        // Vérifie si le formulaire a été soumis et est valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Vérifie si le véhicule existe déjà par sa marque et son modèle
            $existingVehicule = $repository->findMarqueAndModele($vehicule->getMarque(), $vehicule->getModele());
            if ($existingVehicule) {
                $this->addFlash('danger', 'La voiture existe déjà');
                return $this->redirectToRoute('admin.vehicule.index');
            }

            // Persiste le nouveau véhicule dans la base de données
            $em->persist($vehicule);
            $em->flush();

            $this->addFlash('success', 'Le véhicule a été créé avec succès');
            return $this->redirectToRoute('admin.vehicule.index');
        }

        return $this->render('admin/vehicule/create.html.twig', [
            'controller_name' => 'VehiculeController',
            'form' => $form,
        ]);
    }

    // Route pour supprimer un véhicule
    #[Route('/{id}', name: 'delete', methods: ['DELETE'], requirements: ['id' => Requirement::DIGITS])]
    public function remove(Request $request, Vehicule $vehicule, EntityManagerInterface $em): Response
    {
        // Supprime le véhicule
        $em->remove($vehicule);
        $em->flush();
        $this->addFlash('success', 'La voiture a été supprimée avec succès');
        return $this->redirectToRoute('admin.vehicule.index');
    }

    // Route pour rechercher des véhicules
    #[Route('/search', name: 'search')]
    public function search(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Crée le formulaire de recherche
        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);
        $results = [];

        // Vérifie si le formulaire a été soumis et est valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupère les données de recherche
            $data = $form->getData();
            return $this->redirectToRoute('admin.vehicule.search_result', [
                'dateDebut' => $data->getDateDebut()->format('Y-m-d'),
                'dateFin' => $data->getDateFin()->format('Y-m-d'),
                'prix_par_jour' => $data->getPrixParJour()
            ]);
        }

        return $this->render('admin/vehicule/search.html.twig', [
            'controller_name' => 'VehiculeController',
            'form' => $form,
            'results' => $results,
        ]);
    }

    // Route pour afficher les résultats de recherche des véhicules
    #[Route('/search/result', name: 'search_result')]
    public function searchResult(Request $request, VehiculeRepository $vehiculeRepository): Response
    {
        // Récupère les critères de recherche depuis la requête
        $dateDebut = $request->query->get('dateDebut');
        $dateFin = $request->query->get('dateFin');
        $prixParJour = $request->query->get('prix_par_jour');

        // Récupère les véhicules correspondant aux critères
        $results = $vehiculeRepository->findByCriteria($dateDebut, $dateFin, $prixParJour);

        return $this->render('admin/vehicule/search_result.html.twig', [
            'results' => $results,
        ]);
    }
}
