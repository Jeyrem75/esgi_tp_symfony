<?php

namespace App\Form;

use App\Entity\Recipe;
use App\Entity\Review;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReviewAddType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('rating', null, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Entrez une note (1 à 5)'],
                'label' => 'Note',
            ])
            ->add('comment', null, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Ajoutez un commentaire'],
                'label' => 'Commentaire',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Review::class,
        ]);
    }
}
