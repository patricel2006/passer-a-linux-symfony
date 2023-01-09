<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Component\Mime\Email;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Form;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact', methods: ['GET', 'POST'])]
    public function index(Request $request, EntityManagerInterface $entityManagerInterface, MailerInterface $mailerInterface): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $data_contact = $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // envoyer un email de confirmation : 

            $email = (new TemplatedEmail())
                ->from($data_contact->get('email')->getData())
                ->to('contact@passer-a-linux.com')
                ->replyTo($data_contact->get('email')->getData())
                ->subject('sujet du message')
                ->htmlTemplate('contact/contact.html.twig')
                ->context([
                    'mail' => $data_contact->get('email')->getData(),
                    'message' => $data_contact->get('message')->getData(),
                ]);

            try {
                $mailerInterface->send($email);
                $entityManagerInterface->persist($contact);
                $entityManagerInterface->flush();
                $this->addFlash('success', "Votre message a bien été envoyé");
            } 
            
            catch (TransportExceptionInterface $e) {
                $this->addFlash('error', "Erreur lors de l'envoi du message");
            }
            return $this->redirectToRoute('app_index');
        }



        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
