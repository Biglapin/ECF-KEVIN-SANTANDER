<?php

namespace App\Form;

use App\Entity\Reservation;
use App\Entity\Room;
use App\Repository\HotelRepository;
use App\Repository\RoomRepository;
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
            //'choice_label' => 'title',
            'label' => "Choose your room",
/*             'query_builder' => function (RoomRepository $er) use ($options) {
                return $er->createQueryBuilder('h')
                ->andWhere('hotelId = :hotelId') 
                ->setParameter('hotelId', $options['hotelId']);
            }, */
            'choice_label' => function ($title) {
                return $title->getTitle();
            }
            
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
        ->add('submit', SubmitType::class, [
            'label' => 'Book Now'
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
