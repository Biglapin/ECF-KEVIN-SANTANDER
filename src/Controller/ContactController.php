<?php

namespace App\Controller;


use App\Form\ContactType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, MailerInterface $mailer): Response
    {
    
        $form = $this->createForm( ContactType::class)->handleRequest($request);

        
        if($form->isSubmitted() && $form->isValid()) {
            
            $contactFormData = $form->getData();
            $message = (new TemplatedEmail())
                ->from('kevin.santander@devfactory.fr')
                ->to('k.santand@gmail.com')
                ->subject($contactFormData['subject'])
                ->htmlTemplate('email/contact.html.twig')
                ->context([
                    'emailData' => $contactFormData['email'],
                    'subject' => $contactFormData['subject'],
                    'lastname' => $contactFormData['lastname'],
                    'firstname' => $contactFormData['firstname'],
                    'messageData' => $contactFormData['message']
                ]);

            $mailer->send($message);

            $this->addFlash('success', 'Your message has been sent');

            return $this->redirectToRoute('app_contact');
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
