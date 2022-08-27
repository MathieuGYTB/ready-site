<?php

$to = "guyotmathieu572@gmail.com";
$objet = $_POST['objet'];
$message = $_POST['message'];
$nom = $doctrine->getRepository(User::class)->find($nom);
$prenom = $doctrine->getRepository(User::class)->find($prenom);

$message = wordwrap($message, 70, "\r\n");

mail($to, $objet, $message);