<?php

namespace App\Controller;

use App\Form\ModifyPasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class AccountPasswordController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager)
    {}


    #[Route('/account/modify-password', name: 'account_password')]
    public function index(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {

        $notification = null; 
        $user = $this->getUser();
        $form = $this->createForm(ModifyPasswordType::class, $user);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $old_password = $form->get('old_password')->getData();

            if($passwordHasher->isPasswordValid($user, $old_password)) {
                $new_password = $form->get('new_password')->getData();
                $password = $passwordHasher->hashPassword($user, $new_password);

                $user->setPassword($password);
                $this->entityManager->flush();
                $notification = 'Your password has been changed';
            } else {
                $notification = 'Your password is not identical, please retry';
            }
        }

        return $this->render('account/password.html.twig', [
            'form' => $form->createView(),
            'notification' => $notification
        ]);
    }
}
