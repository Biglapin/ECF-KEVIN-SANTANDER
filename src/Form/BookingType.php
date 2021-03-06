<?php

namespace App\Form;

use App\Entity\Reservation;
use App\Entity\Room;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('checkin', DateType::class, [
            'label' => 'Check in',
            'widget' => 'single_text',
        ])
        ->add('checkout', DateType::class, [
            'label' => 'Check out',
            'widget' => 'single_text'
        ])
        ->add('submit', SubmitType::class, [
            'label' => 'Book Now'
        ])
        ->add('getHotelId', EntityType::class, array (
            'class' => Room::class,
            'choice_label' => 'getHotelId',
            'label' => false,
            'mapped' => false
        )) 
        ->add('roomId', EntityType::class, array(
            'class' => Room::class,
            'mapped' => false,
            
            'choice_label' => function ($title) {
                return $title->getTitle();
            },
            'label' => false
        )); 
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
