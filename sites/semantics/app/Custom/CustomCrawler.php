<?php

namespace App\Custom;



use App\Models\Job;
use App\Models\Url;
use App\Models\SeoAuditStructure;
use Psr\Http\Message\UriInterface;
use Illuminate\Support\Facades\Log;
use LanguageDetector\LanguageDetector;
use App\Custom\Tools\HtmlScrapper\HtmlScrapper;
use Spatie\Crawler\CrawlObservers\CrawlObserver;

class CustomCrawler extends CrawlObserver
{

    protected $uuid;
    private $count;
    private $maximumCrawlCount;
    private $typeContent;

    public function __construct($uuid, $maximumCrawlCount, $typeContent = 'full')
    {
        $this->uuid = $uuid;
        $this->count = 0;
        $this->maximumCrawlCount = (int)$maximumCrawlCount;
        $this->typeContent  = $typeContent;
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
        if ($this->typeContent === 'full') {
            $content = $htmlParser->getFullContentText();
        } else {
            $content = $htmlParser->getLightContentText();
        }
        $detector = new LanguageDetector();
        try {
            $language = $detector->evaluate(substr($content, 0, 500))->getLanguage();
        } catch (\Exception $e) {
            Log::error('language : ' . $e->getMessage());
            return;
        }
        if ($language->getCode() !== 'fr') {
            Log::error('Langue non traitée : ' . $language->getCode());
            return;
        }

        try {
            $newUrl = Url::firstOrCreate([
                'uuid' => $this->uuid,
                'url' => (string)$url
            ], [
                'title' => $htmlParser->title(),
                'content' => $content,
            ]);
        } catch (\Exception $e) {
            Log::error('newUrl create : ' . $e->getMessage());
        }

        // Insertion structure HTML de la page
        try {
            SeoAuditStructure::firstOrCreate(array_merge(['uuid' => $this->uuid, 'url_id' => $newUrl->id], ['structure' => $htmlParser->run()]));
        } catch (\Exception $e) {
            Log::error('SeoAuditStructure : ' . $e->getMessage());
        }

        $this->count++;
        try {
            Job::insertUpdate(['uuid' => $this->uuid, 'percentage' => 50, 'message' => '[' . $this->count . '/' . $this->maximumCrawlCount . '] ' . (string)$url]);
        } catch (\Exception $e) {
            Log::error('Job insert : ' . $e->getMessage());
        }
    }

    public function crawlFailed(\Psr\Http\Message\UriInterface $url, \GuzzleHttp\Exception\RequestException $requestException, ?\Psr\Http\Message\UriInterface $foundOnUrl = null): void
    {
        Log::debug('[crawlFailed] : ' . (string)$url);
        Log::debug('Status : ' . $requestException->getCode());
        Log::debug($requestException->getMessage());
    }
}
