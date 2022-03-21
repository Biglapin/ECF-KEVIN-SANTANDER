<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Email',
                /* 'constraints' => new Length(60, 2) */
            ])
            ->add('lastname', TextType::class,[
              'label' => 'Lastname',
            ])
            ->add('firstname', TextType::class,[
              'label' => 'Firstname',
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
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Submit'
            ])
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
