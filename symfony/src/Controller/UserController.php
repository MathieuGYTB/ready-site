<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\InvoiceRepository;

class UserController extends AbstractController
{
  /**
  * @Route("/profile/user")
  */
  #[Route("{{ path('app_user')}}", name: 'app_user')]
  public function user(InvoiceRepository $invoiceRepository): Response
    {

      $user = $this->getUser();
      $user_name = $user->getNom();
      $user_name = ucfirst($user_name);
      $user_firstname = $user->getPrenom();
      $user_firstname = ucfirst($user_firstname);
      $user_email = $user->getEmail();
      $user_role = $user->getRoles();

      $invoice = $invoiceRepository->findBy(['user' => $user]);

      return $this->render(view: 'user/user.html.twig', parameters:[
        'user_name'=> $user_name,
        'user_firstname' => $user_firstname,
        'user_email' => $user_email,
        'user_role' => $user_role,
        'invoice' => $invoice,
      ]);
    }
}