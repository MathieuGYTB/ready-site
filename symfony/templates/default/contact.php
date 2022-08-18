<?php

$to = "mat.68@orange.fr";
$objet = $_POST['objet'];
$message = $_POST['message'];

$message = wordwrap($message, 70, "\r\n");

mail($to, $objet, $message);