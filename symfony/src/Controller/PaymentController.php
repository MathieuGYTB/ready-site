<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class PaymentController extends AbstractController
{
    #[Route('/profile/commandez', name: 'commandez')]
    public function checkout(): Response
    {
    
        $stripeSK = $this->getParameter('stripe_test_secret_key');
        \Stripe\Stripe::setApiKey($stripeSK);

        $YOUR_DOMAIN = 'http://symfony.localhost';
        $user_email = $this->getUser()->getEmail();

        $product_price = $this->getParameter('product_price');
        
        $checkout_session = \Stripe\Checkout\Session::create([
            'billing_address_collection' => "required",
            'custom_text' => [
                'submit' => [
                    'message' => 'En cliquant sur j\'accepte, vous renoncez à votre droit à un délai de rétractation de 14 jours et ne pourrez demander un remboursement.',
                ],
            ],
            'consent_collection' => [
                'terms_of_service' => 'required',
            ],
            'customer_email' => $user_email,
            'line_items' => [[
                # Provide the exact Price ID (e.g. pr_1234) of the product you want to sell
                'price' => $product_price,
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'allow_promotion_codes' => true,
            'invoice_creation' => [
                'enabled' => true,
                'invoice_data' => [
                    'custom_fields' => [
                        [
                            'name' => 'SIRET',
                            'value' => '832 189 021 00021',
                        ],
                        [
                            'name' => 'Code APE',
                            'value' => '6201Z',
                        ],
                        [
                            'name' => 'TVA',
                            'value' => 'non applicable ART.293B du CGI',
                        ],
                    ],
                ],
            ],
            'success_url' => $YOUR_DOMAIN . '/profile/kgfnhtl1616gbvh',
            'cancel_url' => $YOUR_DOMAIN . '/',
            'automatic_tax' => [
                'enabled' => true,
            ],
        ]);

        return $this->redirect($checkout_session->url, 303);
        
    }

    #[Route('/profile/kgfnhtl1616gbvh', name: 'app_success')]
    public function success(): Response
    {
        return $this->render(view: 'payment/success.html.twig');
    }
}
