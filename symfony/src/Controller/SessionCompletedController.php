<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SessionCompletedController extends AbstractController
{
    #[Route('/session/completed', name: 'app_session_completed')]
    public function index(EntityManagerInterface $entityManagerInterface): Response
    {
        // Set your secret key. Remember to switch to your live secret key in production.
        // See your keys here: https://dashboard.stripe.com/apikeys
        \Stripe\Stripe::setApiKey('sk_test_51LeDueKgHxrl7uH30Bcdhjo2Lp7DkfhJhTCR3IYM65bUj5VYAWLVMeXe4gA8nBpVVybT9PyplESArJccqjfSUCHr00gExJt9S5');

        // You can find your endpoint's secret in your webhook settings
        $endpoint_secret = 'whsec_3debc21557e4224524dd82fcf465146d22462c312ce8a472120bcc4f85b37561';

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
    function fulfill_order($line_items) {
        // TODO: fill me in
        error_log("Fulfilling order...");
        error_log($line_items);
    }

    // Handle the checkout.session.completed event
    if ($event->type == 'checkout.session.completed') {
        // Retrieve the session. If you require line items in the response, you may include them by expanding line_items.
        $session = \Stripe\Checkout\Session::retrieve([
        'id' => $event->data->object->id,
        'expand' => ['line_items'],
        ]);

        $line_items = $session->line_items;
        // Fulfill the purchase...
        fulfill_order($line_items);
    }

    if ($event->type == 'invoice.paid') {
        $user = $this->getUser();
        $user->setRoles(['ROLE_PAYED']);
        $entityManagerInterface->persist($user);
        $entityManagerInterface->flush();
    }

    http_response_code(200);
    error_log("Passed signature verification!");

        return $this->render('session_completed/index.html.twig', [
            'controller_name' => 'SessionCompletedController',
        ]);
    }
}
