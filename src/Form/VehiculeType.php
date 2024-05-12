<?php

namespace App\Form;

use App\Entity\Recipe;
use App\Entity\Vehicule;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Event\PostSubmitEvent;
use Symfony\Component\Form\Event\PreSubmitEvent;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Mime\Message;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;

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
                // Label est optionnel. Par defaut, title
                'empty_data' => '',
            ])
            ->add('modele', TextareaType::class, [
                'empty_data' => '',
            ])
            ->add('slug', HiddenType::class, [
                'required' => false,
            ])

            // ->add('createdAt', null, [
            //     'widget' => 'single_text',
            // ])
            // ->add('updatedAt', null, [
            //     'widget' => 'single_text',
            // ])
            ->add('save', SubmitType::class, [
                'label' => 'Envoyer'
            ])
            ->addEventListener(FormEvents::PRE_SUBMIT, $this->factory->autoSlug('marque'));
        // ->addEventListener(FormEvents::POST_SUBMIT, $this->attachTimesStamp(...));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vehicule::class,
            'validation_groups' => ['Default', 'Extra']
        ]);
    }
}
