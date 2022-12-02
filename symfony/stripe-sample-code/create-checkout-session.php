<?php

require 'vendor/autoload.php';
// This is your test secret API key.
\Stripe\Stripe::setApiKey('sk_test_51LeDueKgHxrl7uH30Bcdhjo2Lp7DkfhJhTCR3IYM65bUj5VYAWLVMeXe4gA8nBpVVybT9PyplESArJccqjfSUCHr00gExJt9S5');

header('Content-Type: application/json');

$YOUR_DOMAIN = 'http://symfony.localhost';

$checkout_session = \Stripe\Checkout\Session::create([
  'line_items' => [[
    # Provide the exact Price ID (e.g. pr_1234) of the product you want to sell
    'price' => '{{PRICE_ID}}',
    'quantity' => 1,
  ]],
  'mode' => 'payment',
  'success_url' => $YOUR_DOMAIN . '/success.html',
  'cancel_url' => $YOUR_DOMAIN . '/cancel.html',
  'automatic_tax' => [
    'enabled' => true,
  ],
]);

header("HTTP/1.1 303 See Other");
header("Location: " . $checkout_session->url);