<?php
namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends AbstractController
{

  /**
   * @Route("/")
   */
    public function index()
    {
        return new Response('Hello world!');
    }

    /**
     * @Route("/contact")
     */
    public function contact()
    {
      return $this->render(view: 'default/contact.html.twig');
    }

}