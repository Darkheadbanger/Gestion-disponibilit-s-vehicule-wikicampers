<?php

namespace App\Form;

use Symfony\Component\Form\Event\PostSubmitEvent;
use Symfony\Component\Form\Event\PreSubmitEvent;
use Symfony\Component\String\Slugger\AsciiSlugger;

class FormListenerFactory
{
    /**
     * Crée un écouteur d'événement pour générer automatiquement un slug.
     * 
     * @param string $field Le champ à partir duquel générer le slug.
     * @return \Closure La fonction de rappel qui sera appelée avant la soumission du formulaire.
     */
    public function autoSlug(string $field)
    {
        return function (PreSubmitEvent $event) use ($field) {
            // Récupère les données du formulaire
            $data = $event->getData();
            
            // Si le champ slug est vide, génère un slug à partir du champ spécifié
            if (empty($data['slug'])) {
                $slugger = new AsciiSlugger();
                $data['slug'] = strtolower($slugger->slug($data[$field]));
                // Met à jour les données du formulaire avec le nouveau slug
                $event->setData($data);
            }
        };
    }

    /**
     * Crée un écouteur d'événement pour ajouter des horodatages aux entités.
     * 
     * @return \Closure La fonction de rappel qui sera appelée après la soumission du formulaire.
     */
    public function timestamp()
    {
        return function (PostSubmitEvent $event) {
            // Récupère les données du formulaire
            $data = $event->getData();
            
            // Met à jour la date de modification
            $data->setUpdatedAt(new \DateTimeImmutable());
            
            // Si l'entité n'a pas encore d'identifiant, c'est une nouvelle entité
            // Met à jour la date de création
            if (!$data->getId()) {
                $data->setCreatedAt(new \DateTimeImmutable());
            }
        };
    }
}
