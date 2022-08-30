<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Bill;
use App\Repository\BillRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

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
      $user_bill_id = $this->getUser()->getBillId();

      return $this->render(view: 'user/user.html.twig', parameters:[
        'user_name'=> $user_name,
        'user_firstname' => $user_firstname,
        'user_email' => $user_email,
        'user_bill_id' => $user_bill_id,
      ]);
    }
}