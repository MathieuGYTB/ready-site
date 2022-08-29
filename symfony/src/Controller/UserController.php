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
      $nom = $this->getUser()->getNom();
      $nom = ucfirst($nom);
      $prenom = $this->getUser()->getPrenom();
      $prenom = ucfirst($prenom);
      $email = $this->getUser()->getEmail();
      $id = $this->getUser()->getBillId();
      $description = 'pack de démarrage';
      $quantity = '1';
      $price = '29,99';
      $money = 'euros';

      return $this->render(view: 'user/user.html.twig', parameters:[
        'nom'=> $nom,
        'prenom' => $prenom,
        'email' => $email,
        'id' => $id,
        'description' => $description,
        'quantité' => $quantity,
        'prix' => $price,
        'monaie' => $money
      ]);
    }
}