<?php

namespace App\Form;

use App\Entity\Reservation;
use App\Entity\Room;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('getHotelId', EntityType::class, array (
            'class' => Room::class,
            'choice_label' => 'getHotelId',
            'label' => 'Choose your hotel',
            'mapped' => false
        )) 
        ->add('roomId', EntityType::class, array(
            'class' => Room::class,
            'choice_label' => 'title',
            'label' => "Choose your room",
            //'mapped' => false
        ))
        ->add('checkin', DateType::class, [
            'label' => 'Check in',
            'widget' => 'single_text',
            /* 'html5' => false, */
        ])
        ->add('checkout', DateType::class, [
            'label' => 'Check out',
            'widget' => 'single_text'
        ])
        ->add('submit', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
