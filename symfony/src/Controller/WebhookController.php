<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

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
                    $invoice_amout_paid = $invoice_data->amount_paid;
                    $user_address = $invoice_data->customer_address->line1;
                    $user_code_postal = $invoice_data->customer_address->postal_code;
                    $user_city = $invoice_data->customer_address->city;
                    $user_country = $invoice_data->customer_address->country;

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
                    
                    http_response_code(200);

                    

            } catch (\Exception $e) {
              return $e->getMessage();
            }
                // ... handle other event types
        } else {
            echo 'Received unknown event type ' . $event->type;
        }
        return $this->render('webhook/index.html.twig', [
            'controller_name' => 'WebhookController',
        ]);
    }
}
