<?php

namespace App\Form;

use App\Form\DisponibiliteType;
use App\Entity\Vehicule;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VehiculeType extends AbstractType
{
    public function __construct(private FormListenerFactory $factory)
    {
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('marque', TextType::class, [
                'label' => 'Marque de voiture',
            ])
            ->add('modele', TextType::class, [
                'label' => 'Modèle',
            ])
            ->add('disponibilite', DisponibiliteType::class, [
                'by_reference' => false, // A voir
            ]) // Utilisation du formulaire spécifique
            ->add('slug', HiddenType::class, [
                'required' => false,
            ])
            ->add('save', SubmitType::class, ['label' => 'Envoyer'])
            ->addEventListener(FormEvents::PRE_SUBMIT, $this->factory->autoSlug('marque'));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vehicule::class,
            'validation_groups' => ['Default', 'Extra']
        ]);
    }
}
