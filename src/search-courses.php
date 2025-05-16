<?php

use GuzzleHttp\Client;

$client = new Client();
$client->request('GET', 'https://www.alura.com.br/cursos-online-programacao/php');