<?php

namespace Athena272\CourseSearchEngine\Models;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
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
    private Crawler $crawler;

    public function __construct(ClientInterface $httpClient, Crawler $crawler)
    {
        $this->httpClient = $httpClient;
        $this->crawler = $crawler;
    }

    /**
     * @throws GuzzleException
     */
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