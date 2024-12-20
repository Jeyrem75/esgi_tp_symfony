<?php

namespace App\Form;

use App\Entity\Ingredient;
use App\Entity\Recipe;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IngredientType extends AbstractType
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
            ->add('recipes', EntityType::class, [
                'class' => Recipe::class,
                'choice_label' => 'id',
                'multiple' => true,
                'attr' => ['class' => 'form-select'],
                'label' => 'Recettes associées',
                'help' => 'Sélectionnez une ou plusieurs recettes associées à cet ingrédient.',
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
