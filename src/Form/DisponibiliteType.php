<?php

namespace App\Form;

use App\Entity\Disponibilite;
use App\Entity\Vehicule;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DisponibiliteType extends AbstractType
{
    public function __construct(private FormListenerFactory $factory)
    {
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateDebut', DateTimeType::class, [
                'widget' => 'single_text',
            ])
            ->add('dateFin', DateTimeType::class, [
                'widget' => 'single_text',
            ])
            ->add('prixParJour', NumberType::class)
            ->add('slug', HiddenType::class, [
                'required' => false,
            ])
            // ->add('vehicule', EntityType::class, [
            //     'class' => Vehicule::class,
            //     'required' => 'false',
            //     'choice_label' => function (Vehicule $vehicule) {
            //         return $vehicule->getMarque() . ' ' . $vehicule->getModele(); // ou tout autre attribut pertinent
            //     },
            //     'placeholder' => 'Choisissez un véhicule',
            //     'empty_data' => null,
            // ])
            ->add('isDisponible', CheckboxType::class, [
                'required' => false,
            ])
            ->addEventListener(FormEvents::PRE_SUBMIT, $this->factory->autoSlug('dateDebut'));


    }



    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Disponibilite::class,
            'validation_groups' => ['Default', 'Extra']
        ]);
    }
}
