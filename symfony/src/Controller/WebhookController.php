<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

class WebhookController extends AbstractController
{
    #[Route("{{ path('app_webhook')}}", name: 'app_webhook')]
    public function index(EntityManagerInterface $entityManagerInterface): Response
    {

        
        $whsec_dev = $_ENV['WHSEC_DEV'];
        $whsec_prod = $_ENV['WHSEC_PROD'];
        
        if ($_ENV['APP_ENV'] == 'dev') {
            // This is your Stripe CLI webhook secret for testing your endpoint locally.
            $endpoint_secret = $whsec_dev;
            $stripeSK = $_ENV['STRIPE_TEST_SECRET_KEY'];
            // this is yout Stripe CLI webhook secret for your endpoint in production.
        } else {
            $endpoint_secret = $whsec_prod;
            $stripeSK = $_ENV['STRIPE_PROD_SECRET_KEY'];
        }
        
        \Stripe\Stripe::setApiKey($stripeSK);

        

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
        switch ($event->type) {
            case 'checkout.session.completed':
                $session = $event->data->object;
                $user = $this->getUser();
                
                $invoice_pdf = $session->invoice->invoice_pdf;
                $invoice_number = $session->invoice->invoice_number;
                $invoice_amout_paid = $session->amount_total;
                $user_address = $session->customer_details->address->line1;
                $user_code_postal = $session->customer_details->address->postal_code;
                $user_city = $session->customer_details->address->city;
                $user_country = $session->customer_details->address->country;
                $user->setAdresse($user_address);
                $user->setCodePostal($user_code_postal);
                $user->setCity($user_city);
                $user->setPays($user_country);
                $user->setMontantPayé($invoice_amout_paid);
                $user->setInvoicePdf($invoice_pdf);
                $user->setInvoiceNumber($invoice_number);
                $user->setRoles(['ROLE_PAID']);

                $entityManagerInterface->persist($user);
                $entityManagerInterface->flush();
            // ... handle other event types
            default:
                echo 'Received unknown event type ' . $event->type;
        }
        
        http_response_code(200);

    }
}
