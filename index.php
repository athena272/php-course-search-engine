<?php

require 'vendor/autoload.php';

use Athena272\CourseSearchEngine\Models\CourseFetcher;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

$client = new Client(['verify' => false, 'base_uri' => 'https://www.alura.com.br/']);
$crawler = new Crawler();

$fetcher = new CourseFetcher($client, $crawler);
try {
    $courses = $fetcher->getCourses('/cursos-online-programacao/php');
} catch (\GuzzleHttp\Exception\GuzzleException $e) {
    echo 'Error: ' . $e->getMessage();
}

foreach ($courses as $course) {
    showMessage($course);
}