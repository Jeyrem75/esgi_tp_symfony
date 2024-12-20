<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', null, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Entrez le nom d\'utilisateur'],
                'label' => 'Nom d\'utilisateur',
            ])
            ->add('email', null, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Entrez l\'email'],
                'label' => 'Email',
            ])
            ->add('password', null, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Mot de passe'],
                'label' => 'Mot de passe',
            ])
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Admin' => 'ROLE_ADMIN',
                    'User' => 'ROLE_USER',
                    'Banned' => 'ROLE_BANNED',
                ],
                'multiple' => true,
                'expanded' => true, // Permet d'afficher les cases à cocher
                'label' => 'Rôles',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
