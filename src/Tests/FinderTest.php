<?php

namespace Athena272\CourseSearchEngine\Tests;

use Athena272\CourseSearchEngine\Models\CourseFetcher;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Symfony\Component\DomCrawler\Crawler;

class FinderTest extends TestCase
{
    private $httpClientMock;
    private string $url = 'test-url';

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $html = <<<HTML
        <html>
            <body>
                <span class="card-curso__nome">Test Course 1</span>
                <span class="card-curso__nome">Test Course 2</span>
                <span class="card-curso__nome">Test Course 3</span>
            </body>
        </html>
        HTML;

        $stream = $this->createMock(StreamInterface::class);
        $stream
            ->expects($this->once())
            ->method('__toString')
            ->willReturn($html);

        $response = $this->createMock(ResponseInterface::class);
        $response
            ->expects($this->once())
            ->method('getBody')
            ->willReturn($stream);

        $httpClient = $this->createMock(ClientInterface::class);
        $httpClient
            ->expects($this->once())
            ->method('request')
            ->with('GET', $this->url)
            ->willReturn($response);

        $this->httpClientMock = $httpClient;
    }

    public function testFinderShouldReturnCourses()
    {
        $crawler = new Crawler();
        $finder = new CourseFetcher($this->httpClientMock, $crawler);
        $courses = $finder->getCourses($this->url);

        $this->assertCount(3, $courses);
        $this->assertEquals('Test Course 1', $courses[0]);
        $this->assertEquals('Test Course 2', $courses[1]);
        $this->assertEquals('Test Course 3', $courses[2]);
    }
}