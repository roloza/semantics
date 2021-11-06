<?php

namespace App\Custom\Search;

class DuckDuckGo
{
    private const URL = 'https://duckduckgo.com/?t=hg&iar=images&iax=images&ia=images&q=';
    private $query;
    private $vqd;
    private $type;

    public function __construct($query, $type = 'web')
    {
        $this->query = $query;
        $this->type = $type;
    }

    public function search()
    {
        $response = [];
        $this->vqd = $this->getDuckVqdParam();
        switch ($this->type) {
            case 'web':
                $response = $this->searchWeb();
                break;
            case 'image':
                $response = $this->searchImage();
                break;
        }
        return $response;
    }

    private function getDuckVqdParam() {
        $vqd = null;
        $url = self::URL . urlencode($this->query);
        $content = $this->Download($url);
        preg_match_all("/vqd='(.*?)'/", $content, $matches, PREG_PATTERN_ORDER);
        if (sizeof($matches) == 2) {
            $vqd = current($matches[1]);
        }
        return $vqd;
    }
    private function Download($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec ($ch);
        $err = curl_error($ch);
        curl_close ($ch);
        return $response;
    }

    private function searchWeb()
    {
        $results = [];
        if ($this->vqd === null) {
            return $results;
        }

        $sList = [0, 28, 78/*, 128*/];
        foreach ($sList as $s) {
            $url = 'https://links.duckduckgo.com/d.js?q=' . $this->query . '&kl=wt-wt&l=fr-fr&s=0&a=hm&dl=fr&ct=FR&ss_mkt=fr&vqd=' . $this->vqd;
            if ($s > 0) {
                $url .= '&s=' . $s;
            }
            $content = $this->Download($url);
            $re = '/DDG.inject\(\'DDG\.Data\.languages\.resultLanguages\',(.*?)\);/m';
            preg_match_all($re, $content, $matches, PREG_SET_ORDER, 0);
            if (isset($matches[0][1])) {
                $urls = json_decode(trim($matches[0][1]));
                if (isset($urls->fr)) {
                    $results = array_merge($urls->fr, $results);
                }
            }

        }
        return array_unique($results);
    }

    private function searchImage() {
        $images = [];
        if ($this->vqd === null) {
            return $images;
        }
        $url = 'https://duckduckgo.com/i.js?l=fr-fr&o=json&q='.$this->query.'&vqd='.$this->vqd.'&f=,,,&p=1';
        $content = json_decode($this->Download($url));
        foreach($content->results as $k => $result) {
            $images[] = $result->thumbnail;
        }
        return $images;
    }
}
