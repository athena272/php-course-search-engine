<?php

namespace CourseSearchEngine\Models;

use GuzzleHttp\ClientInterface;
use Symfony\Component\DomCrawler\Crawler;

class CourseFetcher
{
    /**
     * @var ClientInterface
     */
    private $httpClient;

    /**
     * @var Crawler
     */
    private $crawler;

    public function __construct(ClientInterface $httpClient, Crawler $crawler)
    {
        $this->httpClient = $httpClient;
        $this->crawler = $crawler;
    }

    public function getCourses(string $url): array
    {
        $response = $this->httpClient->request('GET', $url);
        $html = $response->getBody();
        $this->crawler->addHtmlContent($html);

        $cousers = $this->crawler->filter('span.card-curso__nome');
        // Transform NodeList into array of course names
        $coursesNames = [];
        foreach ($cousers as $couser) {
            $coursesNames[] = $couser->textContent;
        }

        return $coursesNames;
    }
}