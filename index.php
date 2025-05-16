<?php

require 'vendor/autoload.php';
require 'src/Models/CourseFetcher.php';

use CourseSearchEngine\Models\CourseFetcher;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

$client = new Client(['verify' => false, 'base_uri' => 'https://www.alura.com.br/']);
$crawler = new Crawler();

$fetcher = new CourseFetcher($client, $crawler);
$courses = $fetcher->getCourses('/cursos-online-programacao/php');

foreach ($courses as $course) {
    echo $course . PHP_EOL;
}