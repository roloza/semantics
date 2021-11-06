<?php


namespace App\Custom\Search;

use Illuminate\Support\Facades\Log;


class GoogleNewsRss
{
    private const URL = 'https://news.google.com/rss/search?hl=fr&gl=FR&ceid=FR:fr&q=';
    private $query;

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function search()
    {
        $urls = [];

        $news = simplexml_load_file(self::URL . urlencode($this->query));
        foreach ($news->channel->item as $item)
        {
            try {
                if (strlen((string)$item->link) > 192) {
                    continue;
                }
                $urls[] = (string) $item->link;
            } catch (\Exception $err) {
                Log::error('[GoogleNewsRss] Erreur : ' . $err->getMessage());
            }

        }
        return $urls;
    }
}
