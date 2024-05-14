<?php

namespace App\Form;

use App\Entity\Disponibilite;
use App\Entity\Vehicule;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
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
            ->add('dateDebut', null, [
                'widget' => 'single_text',
            ])
            ->add('dateFin', null, [
                'widget' => 'single_text',
            ])
            ->add('prixParJour', NumberType::class, [
                'required' => true,
                'scale' => 2,
            ])
            ->add('isDisponible', CheckboxType::class, [
                'required' => true,
                // 'label' => 'Disponible ?',
            ])
            ->add('slug', HiddenType::class, [
                'required' => false,
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Envoyer'
            ])
            ->addEventListener(FormEvents::PRE_SUBMIT, $this->factory->autoSlug('vehicule'));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Disponibilite::class,
        ]);
    }
}
