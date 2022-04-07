<?php

namespace BuscadorDeCursos;

use GuzzleHttp\ClientInterface;
use Symfony\Component\DomCrawler\Crawler;

class Buscador
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

    public function buscar(string $url): array
    {
        $resp = $this->httpClient->request('GET', $url);

        $html = $resp->getBody();
        $this->crawler->addHtmlContent($html);

        $listaCursos = $this->crawler->filter('span.card-curso__nome');
        $cursos = [];

        foreach ($listaCursos as $curso) {
            $cursos[] = $curso->textContent;
        }
        return $cursos;
    }
}
