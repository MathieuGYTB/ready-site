<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends AbstractController
{
    #[Route('/profile/commandez', name: 'commandez')]
    public function checkout($stripeSK): Response
    {
        \Stripe\Stripe::setApiKey($stripeSK);

        $YOUR_DOMAIN = 'http://symfony.localhost';
        $user_email = $this->getUser()->getEmail();

        $checkout_session = \Stripe\Checkout\Session::create([
            'consent_collection' => [
                'terms_of_service' => 'required',
            ],
            'customer_email' => $user_email,
            'line_items' => [[
                # Provide the exact Price ID (e.g. pr_1234) of the product you want to sell
                'price' => 'price_1MCJ8tKgHxrl7uH3doxadPRv',
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $YOUR_DOMAIN . '/profile/success',
            'cancel_url' => $YOUR_DOMAIN . '/',
            'automatic_tax' => [
                'enabled' => true,
            ],
        ]);

        return $this->redirect($checkout_session->url, 303);
    }

    #[Route('/profile/success', name: 'app_success')]
    public function success(): Response
    {
        return $this->render(view: 'payment/success.html.twig');
    }
}
