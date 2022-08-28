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
     * @Route("/profile/contact")
     */
    #[Route('/profile/contact', name: 'contact')]
    public function contact()
    {
      return $this->render(view: 'contact/contact.html.twig');
    }

    /**
     * @Route("/profile/commandez")
     */
    #[Route('/profile/commandez', name: 'commandez')]
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
     * @Route("/profile/user")
     */
    public function user()
    {
      return $this->render(view: 'user/user.html.twig');
    }
}