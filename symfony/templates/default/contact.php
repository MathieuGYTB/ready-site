<?php

$to = "guyotmathieu572@gmail.com";
$objet = $_POST['objet'];
$message = $_POST['message'];

$message = wordwrap($message, 70, "\r\n");

mail($to, $objet, $message);