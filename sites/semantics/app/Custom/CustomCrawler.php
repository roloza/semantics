<?php

namespace App\Custom;



use App\Models\Job;
use App\Models\Url;
use Psr\Http\Message\UriInterface;
use Illuminate\Support\Facades\Log;
use LanguageDetector\LanguageDetector;
use App\Custom\Tools\HtmlParser\HtmlParser;
use Spatie\Crawler\CrawlObservers\CrawlObserver;

class CustomCrawler extends CrawlObserver
{

    protected $uuid;
    private $count;
    private $maximumCrawlCount;

    public function __construct($uuid, $maximumCrawlCount)
    {
        $this->uuid = $uuid;
        $this->count = 0;
        $this->maximumCrawlCount = (int)$maximumCrawlCount;
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

        $htmlParser = new HtmlParser((string)$response->getBody(), $url);

        $content = $htmlParser->getFullContentText();
        // $contentLight = $htmlParser->getLightContentText();

        $detector = new \LanguageDetector\LanguageDetector();
        $language = $detector->evaluate($content)->getLanguage();
        if ($language->getCode() !== 'fr') {
            Log::error('Langue non traitée : ' . $language->getCode());
            return;
        }
        try {
            Url::insertOrIgnore([
                'uuid' => $this->uuid,
                'url' => (string)$url,
                'title' => $htmlParser->getTitle(),
                'content' => $content,
            ]);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return;
        }

            $this->count++;
            Job::where('uuid', $this->uuid)->update(['percentage' => 50, 'message' => '[' . $this->count . '/' . $this->maximumCrawlCount . '] ' . (string)$url]);
    }

    public function crawlFailed(\Psr\Http\Message\UriInterface $url, \GuzzleHttp\Exception\RequestException $requestException, ?\Psr\Http\Message\UriInterface $foundOnUrl = null): void
    {
        Log::debug('[crawlFailed] : ' . (string)$url);
        Log::debug('Status : ' . $requestException->getCode());
        Log::debug($requestException->getMessage());
        // TODO: Implement crawlFailed() method.
    }
}
