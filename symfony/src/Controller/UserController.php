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
  public function user(): Response
    {
      $user_name = $this->getUser()->getNom();
      $user_name = ucfirst($user_name);
      $user_firstname = $this->getUser()->getPrenom();
      $user_firstname = ucfirst($user_firstname);
      $user_email = $this->getUser()->getEmail();
      $user_notice = $this->getUser()->getNotice();

      return $this->render(view: 'user/user.html.twig', parameters:[
        'user_name'=> $user_name,
        'user_firstname' => $user_firstname,
        'user_email' => $user_email,
        'user_notice' => $user_notice,
      ]);
    }
}