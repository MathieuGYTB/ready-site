<?php
  $host_name = 'db5009839459.hosting-data.io';
  $database = 'dbs8342243';
  $user_name = 'dbu541254';
  $password = 'BURTzmLt5ghSu9';

  $link = new mysqli($host_name, $user_name, $password, $database);

  if ($link->connect_error) {
    die('<p>La connexion au serveur MySQL a échoué: '. $link->connect_error .'</p>');
  } else {
    echo '<p>Connexion au serveur MySQL établie avec succès.</p>';
  }
?>