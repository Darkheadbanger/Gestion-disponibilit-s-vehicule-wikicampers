<?php

namespace App\Controller\Admin;

use App\Entity\Disponibilite;
use App\Form\VehiculeType;
use App\Repository\RecipeRepository;
use App\Repository\VehiculeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Vehicule;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\String\Slugger\AsciiSlugger;

#[Route('/admin/vehicules', name: 'admin.vehicule.')]
class VehiculeController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(VehiculeRepository $repository, EntityManagerInterface $em): Response
    {
        $vehicules = $repository->findAll();
        // Créer une nouvelle disponibilité
        // $disponibilite = new Disponibilite();
        // $disponibilite->setDateDebut(new \DateTime('now'));
        // $disponibilite->setDateFin(new \DateTime('+1 day'));
        // $disponibilite->setPrixParJour(100.00);
        // $disponibilite->setDisponible(true);
        // $disponibilite->setSlug('test-disponibilite');

        // // Créer un nouveau véhicule
        // $vehicule = new Vehicule();
        // $vehicule->setMarque('Peugeot');
        // $vehicule->setModele('208');
        // $vehicule->setSlug('peugeot-208');

        // // Associer la disponibilité au véhicule
        // $disponibilite->setVehicule($vehicule);
        // // Persister les entités
        // $em->persist($vehicule);
        // $em->persist($disponibilite);
        // $em->flush();

        // dd($disponibilite->getVehicule());
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
    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'], requirements: ['id' => Requirement::DIGITS])]
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
            // Vérifiez si un véhicule avec la même marque et le même modèle existe déjà
            $existingVehicule = $repository->findMarqueAndModele($vehicule->getMarque(), $vehicule->getModele());
            if ($existingVehicule) {
                $this->addFlash('danger', 'La voiture existe déjà');
                return $this->redirectToRoute('admin.vehicule.index');
            }

            $em->persist($vehicule);
            $em->flush(); // Persiste le véhicule dans la base de données

            // Now that $vehicule has an ID, we can link it to the Disponibilite
            $disponibilite = new Disponibilite();
            $disponibilite->setVehicule($vehicule); // Attache le véhicule à la disponibilité
            $em->persist($disponibilite);

            $em->flush(); // Persiste toutes les modifications dans la base de données

            $this->addFlash('success', 'Le véhicule et la disponibilité ont été créés avec succès');
            return $this->redirectToRoute('admin.vehicule.index');
        }

        return $this->render('admin/vehicule/create.html.twig', [
            'controller_name' => 'VehiculeController',
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'], requirements: ['id' => Requirement::DIGITS])]
    public function remove(Request $request, Vehicule $vehicule, EntityManagerInterface $em): Response
    {
        $em->remove($vehicule);
        $em->flush();
        $this->addFlash('success', 'La recette a été supprimée avec succès');
        return $this->redirectToRoute('admin.vehicule.index');
    }
}
