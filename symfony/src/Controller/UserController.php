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
      $nom = $this->getUser()->getNom();
      $nom = ucfirst($nom);
      $prenom = $this->getUser()->getPrenom();
      $prenom = ucfirst($prenom);

      return $this->render(view: 'user/user.html.twig', parameters:['nom'=> $nom, 'prenom' => $prenom]);
    }
}