<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class DefaultController extends AbstractController
{
    public function index()
    {
        return $this->render('default/index.html.twig');
    }

    public function cgv()
    {
      return $this->render(view: 'default/cgv.html.twig');
    }

    public function rgpd()
    {
      return $this->render(view: 'default/rgpd.html.twig');
    }

    public function licence()
    {
    return $this->render(view: 'default/licence.html.twig');
    }
}