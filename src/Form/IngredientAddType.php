<?php

namespace App\Form;

use App\Entity\Ingredient;
use App\Entity\Recipe;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IngredientAddType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Nom de l\'ingrédient'],
                'label' => 'Nom',
            ])
            ->add('quantity', null, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Quantité'],
                'label' => 'Quantité',
            ])
            ->add('unit', null, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Unité (e.g., grammes, litres)'],
                'label' => 'Unité',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ingredient::class,
        ]);
    }
}
