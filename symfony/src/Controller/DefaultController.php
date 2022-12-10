<?php
namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

    public function licence()
    {
    return $this->render(view: 'default/licence.html.twig');
    }
}