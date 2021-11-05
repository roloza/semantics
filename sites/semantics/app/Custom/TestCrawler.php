<?php

namespace App\Custom;

use Spatie\Url\Url;
use App\Models\SeoAuditStructure;
use Psr\Http\Message\UriInterface;
use Illuminate\Support\Facades\Log;
use App\Custom\Tools\HtmlParser\HtmlParser;
use App\Custom\Tools\HtmlScrapper\HtmlScrapper;
use Spatie\Crawler\CrawlObservers\CrawlObserver;

class TestCrawler extends CrawlObserver
{

    private $urlId;

    public function __construct($urlId)
    {
        $this->urlId = $urlId;
    }

    public function willCrawl(UriInterface $url): void
    {
        Log::debug('[willCrawl] : ' . (string)$url);
    }

    public function crawled(\Psr\Http\Message\UriInterface $url, \Psr\Http\Message\ResponseInterface $response, ?\Psr\Http\Message\UriInterface $foundOnUrl = null): void
    {
        Log::debug('[crawled] : ' . (string)$url);

        if ($response->getStatusCode() !== 200) {
            Log::error('Url non traitée. Mauvais statut : ' . $response->getStatusCode());
            return;
        }
        if (strpos(current($response->getHeader('content-type')), 'text/html') === false) {
            Log::error('Url non traitée. Mauvais type' . current($response->getHeader('content-type')));
            return;
        }
        if ($response->getBody()->getSize() <= 1000) {
            Log::error('Url non traitée. Taille trop grande : ' . $response->getBody()->getSize());
            return;
        }

        $htmlParser = new HtmlScrapper((string)$response->getBody(), $url);
        $fullContent = $htmlParser->getFullContentText();
        $contentLight = $htmlParser->getLightContentText();

        dd($fullContent, "\n############################\n", $contentLight, "#######", 'fullContent: ' . strlen($fullContent), 'contentLight : ' . strlen($contentLight));
        $structure = $htmlParser->run();

        $htmlParser = new HtmlParser((string)$response->getBody(), $url);

        $content = $htmlParser->getFullContentText();
        $contentLight = $htmlParser->getLightContentText();


        dd($content, $contentLight);

        $uuid = '1234';

        $doc = array_merge(['url_id' => $this->urlId], $structure);


        try  {
            SeoAuditStructure::where('uuid', $uuid)
                    ->where('url_id', $this->urlId)
                    ->update($doc, ['upsert' => true]);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }

    }

    public function crawlFailed(\Psr\Http\Message\UriInterface $url, \GuzzleHttp\Exception\RequestException $requestException, ?\Psr\Http\Message\UriInterface $foundOnUrl = null): void
    {
        Log::debug('[crawlFailed] : ' . (string)$url);
        Log::debug('Status : ' . $requestException->getCode());
        Log::debug($requestException->getMessage());
        // TODO: Implement crawlFailed() method.
    }

        /**
     * Called when the crawl has ended.
     */
    public function finishedCrawling(): void
    {
        Log::debug('[finishedCrawling]');
    }


}
