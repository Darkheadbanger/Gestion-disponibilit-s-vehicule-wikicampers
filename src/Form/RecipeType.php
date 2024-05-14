<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RecipeType extends AbstractType
{
    public function __construct(private FormListenerFactory $factory)
    {
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
    }
}
