# php-course-search-engine

[![Latest Stable Version](https://img.shields.io/packagist/v/athena272/php-course-search-engine.svg)](https://packagist.org/packages/athena272/php-course-search-engine)
[![License](https://img.shields.io/packagist/l/athena272/php-course-search-engine.svg)](LICENSE)

Projeto que busca cursos do site da Alura de forma automática, usando PHP.

## Instalação

Via [Composer](https://getcomposer.org/):

```bash
composer require athena272/php-course-search-engine
```

## Exemplo de uso
```php
require 'vendor/autoload.php';

use Athena272\CourseSearchEngine\Models\CourseFetcher;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

$client = new Client([
    'verify' => false,
    'base_uri' => 'https://www.alura.com.br/'
]);
$crawler = new Crawler();

$fetcher = new CourseFetcher($client, $crawler);

try {
    $courses = $fetcher->getCourses('/cursos-online-programacao/php');
    foreach ($courses as $course) {
        echo $course . PHP_EOL;
    }
} catch (\GuzzleHttp\Exception\GuzzleException $e) {
    echo 'Error: ' . $e->getMessage();
}
```

## Testes
```bash
composer install
composer test
```

## Dependências
- guzzlehttp/guzzle
- symfony/dom-crawler
- symfony/css-selector
