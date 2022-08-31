<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;


class ContactController extends AbstractController
{
    #[Route('/profile/contact', name: 'app_contact')]
    public function contact(Request $request, MailerInterface $mailer): Response
    {
        $user_name = $this->getUser()->getNom();
        $user_name = ucfirst($user_name);
        $user_firstname = $this->getUser()->getPrenom();
        $user_firstname = ucfirst($user_firstname);
        $user_email = $this->getUser()->getEmail();
        $admin_email = 'guyotmathieu572@gmail.com';


        $contactform = $this->createForm(ContactType::class, ['nom' => $user_name, 'prenom' => $user_firstname, 'email' => $user_email]);

        $contactform->handleRequest($request);

        if ($contactform->isSubmitted() && $contactform->isValid()) {
            $data = $contactform->getData();
            
            $user_message = $_POST["message"];
            $email = (new TemplatedEmail())
            ->from($user_email)
            ->to($admin_email)
            ->subject('utilisateur de mon site')
            ->text($user_message)
            ->htmlTemplate('contact/email.html.twig')
            ->context([ 
                'user_message' => $user_message,
                'user_nom' => $user_name,
                'user_prenom' => $user_firstname,
                'user_email' => $user_email
            ]);

            $mailer->send($email);
        }  

        return $this->render('contact/contact.html.twig', [
            'controller_name' => 'ContactController',
            'contactform' => $contactform->createView(),
        ]);
    }
}