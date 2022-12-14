<?php
// webhook.php
//
// Use this sample code to handle webhook events in your integration.
//
// 1) Paste this code into a new file (webhook.php)
//
// 2) Install dependencies
//   composer require stripe/stripe-php
//
// 3) Run the server on http://symfony.localhost
//   php -S symfony.localhost

require 'vendor/autoload.php';

if ($_ENV['APP_ENV'] == 'dev') {
  // This is your Stripe CLI webhook secret for testing your endpoint locally.
  $endpoint_secret = 'whsec_3debc21557e4224524dd82fcf465146d22462c312ce8a472120bcc4f85b37561';
} else {
  $endpoint_secret = 'whsec_BvMWXkZ6nTW99xMhcZ0GKhZPNQ26tyja';
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
switch ($event->type) {
  case 'checkout.session.completed':
    $session = $event->data->object;
    $invoice_number = $session->invoice->number;
    $invoice_pgf = $session->invoice->invoice_pdf;
    dd($invoice_number);
  // ... handle other event types
  default:
    echo 'Received unknown event type ' . $event->type;
}

http_response_code(200);