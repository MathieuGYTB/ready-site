<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Stripe\StripeObject;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


use function Symfony\Component\DependencyInjection\Loader\Configurator\env;

class PaymentController extends AbstractController
{
    #[Route("{{ path('commandez')}}", name: 'commandez')]
    public function checkout(): Response
    {
        if ($_ENV['APP_ENV'] == 'dev') {
            $stripeSK = $_ENV['STRIPE_TEST_SECRET_KEY'];
        } else {
            $stripeSK = $_ENV['STRIPE_PROD_SECRET_KEY'];
        }
        \Stripe\Stripe::setApiKey($stripeSK);

        $YOUR_DOMAIN = 'http://symfony.localhost';
        $user_email = $this->getUser()->getEmail();
        $product_price = $_ENV['PRODUCT_PRICE'];
        $admin_siret = $_ENV['ADMIN_SIRET'];
        $code_ape = $_ENV['CODE_APE'];
        $tva = $_ENV['TVA'];

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
            'line_items' => [
                [
                    # Provide the exact Price ID (e.g. pr_1234) of the product you want to sell
                    'price' => $product_price,
                    'quantity' => 1,
                ]
            ],
            'mode' => 'payment',
            'allow_promotion_codes' => true,
            'invoice_creation' => [
                'enabled' => true,
                'invoice_data' => [
                    'custom_fields' => [
                        [
                            'name' => 'SIRET',
                            'value' => $admin_siret,
                        ],
                        [
                            'name' => 'Code APE',
                            'value' => $code_ape,
                        ],
                        [
                            'name' => 'TVA',
                            'value' => $tva,
                        ],
                    ],
                ],
            ],
            'success_url' => $YOUR_DOMAIN . "/profile/kgfnhtl1616gbvh?session_id={CHECKOUT_SESSION_ID}",
            'cancel_url' => $YOUR_DOMAIN . "/",
            'automatic_tax' => [
                'enabled' => true,
            ],
        ]);

        return $this->redirect($checkout_session->url, 303);

    }

    #[Route("{{ path('app_succes')}}", name: 'app_success')]
    public function success(EntityManagerInterface $entityManagerInterface): Response
    {

        $whsec_dev = $_ENV['WHSEC_DEV'];
        $whsec_prod = $_ENV['WHSEC_PROD'];

        if ($_ENV['APP_ENV'] == 'dev') {
        // This is your Stripe CLI webhook secret for testing your endpoint locally.
        $endpoint_secret = $whsec_dev;
        // this is yout Stripe CLI webhook secret for your endpoint in production.
        } else {
        $endpoint_secret = $whsec_prod;
        }

        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        try {
            $event = \Stripe\Webhook::constructEvent(
            $payload, $sig_header, $endpoint_secret
        );
        } catch(\UnexpectedValueException $e) {
        // Invalid payload
            http_response_code(400);
        exit();
        } catch(\Stripe\Exception\SignatureVerificationException $e) {
        // Invalid signature
            http_response_code(400);
        exit();
        }
        // Handle the event
        if ($event->type == 'invoice.payment_succeeded') {
            try {

                    $user = $this->getUser();
                    $invoice_data = $event->data->object;
                    $invoice_pdf = $invoice_data->invoice_pdf;
                    $invoice_number = $invoice_data->invoice_number;
                    $user->setInvoicePdf($invoice_pdf);
                    $user->setInvoiceNumber($invoice_number);
                    $user->setRoles(['ROLE_PAID']);

                    $entityManagerInterface->persist($user);
                    $entityManagerInterface->flush();
                    
                return $invoice_pdf;

            } catch (\Exception $e) {
              return $e->getMessage();
            }
                // ... handle other event types
        } else {
            echo 'Received unknown event type ' . $event->type;
        }
    
        http_response_code(200);

        return $this->render(view: 'payment/success.html.twig');
    }

}
