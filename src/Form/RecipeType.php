<?php

namespace App\Form;

use App\Entity\Ingredient;
use App\Entity\Recipe;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', null, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Titre de la recette'],
                'label' => 'Titre',
            ])
            ->add('description', null, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Description de la recette'],
                'label' => 'Description',
            ])
            ->add('image', null, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'URL de l\'image'],
                'label' => 'Image',
            ])
            ->add('duration', null, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Durée en minutes'],
                'label' => 'Durée',
            ])
            ->add('difficulty', null, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Difficulté (e.g., facile, moyen, difficile)'],
                'label' => 'Difficulté',
            ])
            ->add('ingredients', EntityType::class, [
                'class' => Ingredient::class,
                'choice_label' => 'name',
                'multiple' => true,
                'attr' => ['class' => 'form-select'],
                'label' => 'Ingrédients',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recipe::class,
        ]);
    }
}
