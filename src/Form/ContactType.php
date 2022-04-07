<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Gregwar\CaptchaBundle\Type\CaptchaType;

class ContactType extends AbstractType
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
            ->add('lastname', TextType::class,[
              'label' => 'Lastname',
              'constraints' => new Length([
                'min'=> 2,
                'max' => 30
              ])
            ])
            ->add('firstname', TextType::class,[
              'label' => 'Firstname',
              'constraints' => new Length([
                'min'=> 2,
                'max' => 30
              ])
            ])
            ->add('subject', ChoiceType::class,[
              'label' => 'Subject',
              'choices' => [
                'Je souhaite poser une réclamation ' => 'Je souhaite poser une réclamation',
                'Je souhaite commander un service supplémentaire' => "Je souhaite commander un service supplémentaire",
                'Je souhaite en savoir plus sur une suite' => 'Je souhaite en savoir plus sur une suite',
                'J\'ai un souci avec cette application' => 'J\'ai un souci avec cette application'
              ]
            ])
            ->add('message', TextareaType::class,[
              'label' => 'Message',
              'constraints' => new Length([
                'min'=> 2,
                'max' => 500
                ])
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Submit'
            ])
            ->add('captcha', CaptchaType::class, [
                'attr' => ['placeholder' => 'Please enter the letters displayed below'],
          ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'method' => 'get',
            'csrf_protection' => false
        ]);
    }
}
