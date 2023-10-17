#!/usr/bin/env php
<?php
error_reporting(E_ALL);

/* Autorise l'exécution infinie du script, en attente de connexion. */
set_time_limit(0);

/* Active le vidage implicite des buffers de sortie, pour que nous
 * puissions voir ce que nous lisons au fur et à mesure. */
ob_implicit_flush();

$address = '0.0.0.0';
$port = getenv('APP_PORT') ?: 9013;

if (($sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) === false) {
    echo "socket_create() a échoué : raison : " . socket_strerror(socket_last_error()) . "\n";
	exit(1);
}

if (socket_bind($sock, $address, $port) === false) {
    echo "socket_bind() a échoué : raison : " . socket_strerror(socket_last_error($sock)) . "\n";
	exit(1);
}

if (socket_listen($sock, 5) === false) {
    echo "socket_listen() a échoué : raison : " . socket_strerror(socket_last_error($sock)) . "\n";
	exit(1);
}


//connexion à la base de données:
include("conf.php");

$mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname); // on instancie la classe mysqli

if ($mysqli->connect_errno) { // appel de méthode avec l'opérateur ->
	printf("ERROR\n"); 
	exit(1);
}

do {
  if (($msgsock = socket_accept($sock)) === false) {
      echo "socket_accept() a échoué : raison : " . socket_strerror(socket_last_error($sock)) . "\n";
      break;
  }
  socket_getpeername($msgsock,$client);
  $madate=date("Y-m-d H:i:s");
  echo "$madate-$client\n";

  $requete = "SELECT * FROM membres";
  $resultat = $mysqli -> query($requete);
  $msg="HTTP/1.1 200 OK\r\nContent-Type: text/plain\r\n\r\n";
  while ($ligne = $resultat -> fetch_assoc()) {
    $msg.=$ligne['ccmpseudo']. ';'.$ligne['mdp'].';'.$ligne['ccmmail']."\n";
  }

  socket_write($msgsock, $msg, strlen($msg));
  socket_close($msgsock);
} while (true);
$mysqli->close();

socket_close($sock);
?>
