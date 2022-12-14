<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Controller\WebhookController;

class UserController extends AbstractController
{
  /**
  * @Route("/profile/user")
  */
  #[Route("{{ path('app_user')}}", name: 'app_user')]
  public function user(WebhookController $webhookController): Response
    {
      $user_name = $this->getUser()->getNom();
      $user_name = ucfirst($user_name);
      $user_firstname = $this->getUser()->getPrenom();
      $user_firstname = ucfirst($user_firstname);
      $user_email = $this->getUser()->getEmail();
      $user_role = $this->getUser()->getRoles();
      $invoice_pdf = $webhookController->index();

      return $this->render(view: 'user/user.html.twig', parameters:[
        'user_name'=> $user_name,
        'user_firstname' => $user_firstname,
        'user_email' => $user_email,
        'user_role' => $user_role,
        'invoice_pdf' => $invoice_pdf,
      ]);
    }
}