<?php

namespace App\Custom;


use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Psr\Http\Message\UriInterface;
use Spatie\Crawler\CrawlObservers\CrawlObserver;
use League\Csv\Writer;

class SynonymeCrawler extends CrawlObserver
{

    private $keyword;

    public function __construct($keyword = null)
    {
        $this->keyword = $keyword;
    }

    public function willCrawl(UriInterface $url): void
    {
    }

    public function crawled(\Psr\Http\Message\UriInterface $url, \Psr\Http\Message\ResponseInterface $response, ?\Psr\Http\Message\UriInterface $foundOnUrl = null): void
    {

        dd($response->getStatusCode());
        if ($response->getStatusCode() !== 200 || strpos(current($response->getHeader('content-type')), 'text/html') === false || $response->getBody()->getSize() <= 1000) {
            return;
        }

        $crawler = new \Symfony\Component\DomCrawler\Crawler((string)$response->getBody());
        if ($this->keyword !== null) {
            $antonymes = $crawler->filter('.fiche .word')->each(function (\Symfony\Component\DomCrawler\Crawler $node) {
                try {
                    return $node->text();
                } catch (\Exception $e) {

                }
            });
            $response = [];
            foreach ($antonymes as $antonyme) {
                $response[] = [$this->keyword, $antonyme];
            }
            $path = storage_path('app/antonymes/words/');
            $name = Str::slug($this->keyword) . '.csv';

        } else {
            $pathname = explode('/', $url->getPath());
            $name = end($pathname) . '.csv';
            $path = storage_path('app/antonymes/letters/');
            $response = $crawler->filter('.word')->each(function (\Symfony\Component\DomCrawler\Crawler $node) {
                try {
                    return [$node->attr('href'), $node->text()];
                } catch (\Exception $e) {

                }
            });

        }
        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        }
        $writer = Writer::createFromPath($path . $name, 'w');
        $writer->insertAll($response);
    }

    public function crawlFailed(\Psr\Http\Message\UriInterface $url, \GuzzleHttp\Exception\RequestException $requestException, ?\Psr\Http\Message\UriInterface $foundOnUrl = null): void
    {
        Log::error($requestException->getCode() . ' - ' . (string)$url);
        Log::error($requestException->getMessage());
        // TODO: Implement crawlFailed() method.
    }
}
