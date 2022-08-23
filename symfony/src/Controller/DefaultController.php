<?php
namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{

  /**
   * @Route("/")
   */
    public function index()
    {
        return $this->render('default/index.html.twig');
    }

    /**
     * @Route("/contact")
     */
    public function contact()
    {
      return $this->render(view: 'default/contact.html.twig');
    }

    /**
     * @Route("/commandez")
     */
    public function commandez()
    {
      return $this->render(view: 'default/commandez.html.twig');
    }

    /**
     * @Route("/cgv")
     */
    public function cgv()
    {
      return $this->render(view: 'default/cgv.html.twig');
    }

    /**
     * @Route("/rgpd")
     */
    public function rgpd()
    {
      return $this->render(view: 'default/rgpd.html.twig');
    }

    /**
     * @Route("/monEspace")
     */
    public function register()
    {
      return $this->render(view: 'registration/register.html.twig');
    }
    /**
     * @Route("/login")
     */
    public function login()
    {
      return $this->render(view: 'security/login.html.twig');
    }
}