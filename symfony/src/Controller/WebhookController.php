<?php

namespace App\Controller;

use App\Entity\Invoice;
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
                    
                    $invoice = new Invoice();
                    $invoice_data = $event->data->object;
                    $invoice_pdf = $invoice_data->invoice_pdf;
                    $invoice->setPdf($invoice_pdf);
                    $invoice->setUser($user);
                    $entityManagerInterface->persist($invoice);
                    $entityManagerInterface->flush();

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
