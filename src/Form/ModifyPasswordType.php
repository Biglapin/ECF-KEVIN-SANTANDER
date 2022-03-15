<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModifyPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'disabled' => true
            ])
            ->add('firstName',TextType::class, [
                'disabled' => true
            ])
            ->add('lastName',TextType::class, [
                'disabled' => true
            ])
            ->add('old_password', PasswordType::class, [
                'mapped' => false,
                'attr' => [
                    'placeholder' => 'Please enter your password'
                ]
            ])
            ->add('new_password', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'invalid_message' => 'Your password must be identical',
                'label' => 'Password',
                'required' => true, 
                'first_options' => ['label' => 'Password'],
                'second_options' => ['label' => 'Password confirmation']
                ])
            ->add( 'submit', SubmitType::class, [
                'label' => 'Ok',
                'attr' => [
                    'class' => 'btn btn-success'
                ]
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
