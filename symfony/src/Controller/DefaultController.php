CTRL+C pour copier, CTRL+V pour coller
<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
class DefaultController
{
    public function index()
    {
        return new Response('Hello world!');
    }
}