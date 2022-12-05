<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends AbstractController
{
    #[Route('/checkout', name: 'app_checkout')]
    public function checkout($stripeSK): Response
    {
        \Stripe\Stripe::setApiKey($stripeSK);

        $YOUR_DOMAIN = 'http://symfony.localhost';

        $checkout_session = \Stripe\Checkout\Session::create([
            'line_items' => [[
                # Provide the exact Price ID (e.g. pr_1234) of the product you want to sell
                'price' => 'price_1MBZBXKgHxrl7uH3ALEzb4uD',
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $YOUR_DOMAIN . '/success',
            'cancel_url' => $YOUR_DOMAIN . '/profile/commandez',
            'automatic_tax' => [
                'enabled' => true,
            ],
        ]);

        return $this->redirect($checkout_session->url, 303);
    }

    #[Route('/success', name: 'app_success')]
    public function success(): Response
    {
        return $this->render(view: 'default/success.html.twig');
    }
}
