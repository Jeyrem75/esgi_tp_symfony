<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecipeSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'required' => false,
                'label' => 'Titre',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Titre de la recette']
            ])
            ->add('maxDuration', IntegerType::class, [
                'required' => false,
                'label' => 'Temps max (minutes)',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Durée max']
            ])
            ->add('difficulty', ChoiceType::class, [
                'required' => false,
                'choices' => [
                    'Facile' => 'Easy',
                    'Moyenne' => 'Medium',
                    'Difficile' => 'Hard',
                ],
                'placeholder' => 'Toutes les difficultés',
                'label' => 'Difficulté',
                'attr' => ['class' => 'form-select']
            ])
            ->add('ingredients', ChoiceType::class, [
                'choices' => $options['ingredients'], // Vous passerez ces options dans les données du formulaire
                'multiple' => true,
                'expanded' => false,
                'required' => false,
                'label' => false,
                'attr' => ['class' => 'form-select']
            ])
            ->add('excludedIngredients', ChoiceType::class, [
                'choices' => $options['ingredients'], // Les mêmes choix pour inclure ou exclure
                'multiple' => true,
                'expanded' => false,
                'required' => false,
                'label' => false,
                'attr' => ['class' => 'form-select']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'ingredients' => [],
        ]);
    }
}
