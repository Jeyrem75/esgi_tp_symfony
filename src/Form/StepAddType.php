<?php

namespace App\Form;

use App\Entity\Recipe;
use App\Entity\Step;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StepAddType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('number', null, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Entrez le numéro de l\'étape'],
                'label' => 'Numéro de l\'étape',
            ])
            ->add('description', null, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Entrez la description'],
                'label' => 'Description',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Step::class,
        ]);
    }
}
