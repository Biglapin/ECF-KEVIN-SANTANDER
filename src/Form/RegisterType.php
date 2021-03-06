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
use Symfony\Component\Validator\Constraints\Length;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'constraints' => new Length([
                    'min' => 5,
                    'max' => 60
                ])
            ])
            ->add('firstName', TextType::class, [
                'label' => 'First name',
                'constraints' => new Length([
                    'min'=> 2,
                    'max' => 30
                ])
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Last name',
                'constraints' => new Length([
                    'min'=> 2,
                    'max' => 30
                ])
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Your password must be identical',
                'label' => 'Password',
                'constraints' => new Length([
                    'min'=> 5,
                    'max' => 30
                ]),
                'required' => true, 
                'first_options' => ['label' => 'Password'],
                'second_options' => ['label' => 'Password Confirmation']
                ])
            ->add('submit', SubmitType::class, [
                'label' => 'Submit'
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
