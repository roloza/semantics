<?php


namespace App\Custom\Search;


class Qwant
{
    private const URL = 'https://api.qwant.com/v3/search/web?count=10&locale=fr_FR&device=desktop&safesearch=0';
    private $query;
    private $offsetMax;

    public function __construct($query, $offsetMax = 40)
    {
        $this->query = $query;
        $this->offsetMax = $offsetMax;
    }

    public function search()
    {
        return $this->searchWeb();
    }

    private function Download($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, self::randomUserAgent());
        $response = curl_exec ($ch);
        curl_close ($ch);
        return $response;
    }

    private function searchWeb()
    {
        $results = [];
        for($offset = 0; $offset <= $this->offsetMax; $offset+=10){
            $content = json_decode($this->Download(self::URL . '&offset=' . $offset . '&q=' . urlencode($this->query)), true);

            if (!isset($content['data']['result']['items']['mainline'])) continue; // Si l'élément n'existe pas
            foreach ($content['data']['result']['items']['mainline'] as $mainline) {
                if (!isset($mainline['items'])) continue; // Si l'élément n'existe pas
                foreach ($mainline['items'] as $item) {
                    if (!isset($item['url'])) continue; // Si l'élément n'existe pas
                    $results[] = $item['url'];
                }
            }
        }
        return $results;
    }

    private static function randomUserAgent()
    {
        $userAgentList = [
            'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.517 Safari/537.36',
            'Mozilla/5.0 (Windows NT 6.2; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1667.0 Safari/537.36',
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1664.3 Safari/537.36',
        ];
        return $userAgentList[rand(0, sizeof($userAgentList) - 1 )];
    }

}
