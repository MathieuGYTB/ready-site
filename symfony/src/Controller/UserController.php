<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class UserController extends AbstractController
{
  /**
  * @Route("/profile/user")
  */
  #[Route("{{ path('app_user')}}", name: 'app_user')]
  public function user(): Response
    {

      $user = $this->getUser();
      $user_name = $user->getNom();
      $user_name = ucfirst($user_name);
      $user_firstname = $user->getPrenom();
      $user_firstname = ucfirst($user_firstname);
      $user_address = $user->getAdresse();
      $user_code_postal = $user->getCodePostal();
      $user_city = $user->getVille();
      $user_pays = $user->getPays();
      $user_email = $user->getEmail();
      $user_role = $user->getRoles();
      $invoice = $user->getInvoicePdf();

      return $this->render(view: 'user/user.html.twig', parameters:[
        'user_name'=> $user_name,
        'user_firstname' => $user_firstname,
        'user_email' => $user_email,
        'user_address' => $user_address,
        'user_code_postal' => $user_code_postal,
        'user_city' => $user_city,
        'user_pays' => $user_pays,
        'user_role' => $user_role,
        'invoice' => $invoice,
      ]);
    }
}