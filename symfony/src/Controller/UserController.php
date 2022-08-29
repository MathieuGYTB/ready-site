<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Bill;
use App\Repository\BillRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;

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
      //$id = $bill->findBy($id);
      //$description = $bill->findBy($description);
      //$quantity = $bill->findBy($quantity);
      //$price = $bill->findBy($price);
      //$money = $bill->findBy($money);

      //if (!$id) {
      //  throw $this->createNotFoundException(
      //      'Pas de facture '
      //  );
      //}

      return $this->render(view: 'user/user.html.twig', parameters:[
        'nom'=> $nom,
        'prenom' => $prenom,
        'email' => $email
        //'id' => $id,
        //'description' => $description,
        //'quantité' => $quantity,
        //'prix' => $price,
        //'monaie' => $money
      ]);
    }
}