<?php
namespace App\Custom\Search;

use Astatroth\LaravelTimer\Timer;
use Illuminate\Support\Facades\Log;

class Suggest
{

    private const URL = 'https://paulgo.io/autocompleter';
    /** Liste searx : https://searx.space */
    private const URLS = [
        'https://paulgo.io/autocompleter',
        'https://searx.tiekoetter.com/autocompleter',
        'https://searx.bar/autocompleter',
        'https://paulgo.io/autocompleter',
        //Error 'https://search.asynchronousexchange.com/autocompleter',
        'https://anon.sx/autocompleter',
        'https://search.disroot.org/autocompleter',
        'https://sx.fedi.tech/autocompleter',
        'https://search.mdosch.de/autocompleter',
        'https://searx.fmac.xyz/autocompleter',
        'https://xeek.com/autocompleter',
        'https://searx.ru/autocompleter',
        'https://searx.hummel-web.at/autocompleter',
        //Error 'https://searx.prvcy.eu/autocompleter',
        'https://searx.webheberg.info/autocompleter',
        'https://www.gruble.de/autocompleter',
        'https://searx.silkky.cloud/autocompleter',
        'https://searx.zackptg5.com/autocompleter',
        'https://search.blou.xyz/autocompleter',
        'https://swag.pw/autocompleter',
        'https://searx.stuehieyr.com/autocompleter',
        'https://searx.tux.land/autocompleter',
        'https://searx.gnous.eu/autocompleter',
        'https://s.zhaocloud.net/autocompleter',
        'https://searx.xyz/autocompleter',
        'https://searx.bissisoft.com/autocompleter',
        'https://northboot.xyz/autocompleter',
        //Lent 'https://searx.tuxcloud.net/autocompleter',
        'https://searx.theanonymouse.xyz/autocompleter',
        'https://procurx.pt/autocompleter',
        'https://metasearch.nl/autocompleter',
        'https://searx.rasp.fr/autocompleter',
        'https://searx.nevrlands.de/autocompleter',
        'https://searx.sp-codes.de/autocompleter',
        'https://searx.divided-by-zero.eu/autocompleter',
        'https://searx2.zackptg5.com/autocompleter',
        // Lent 'https://search.bluelock.org/autocompleter',
        'https://searx.pwoss.org/autocompleter',
        'https://search.076.ne.jp/searx/autocompleter',
        'https://searx.mha.fi/autocompleter',
        'https://searx.sunless.cloud/autocompleter',
        'https://searx.roflcopter.fr/autocompleter',
        'https://searx.zecircle.xyz/autocompleter',
        'https://search.snopyta.org/autocompleter',
        'https://searx.dresden.network/autocompleter',
        'https://searx.netzspielplatz.de/autocompleter',
        'https://searx.mastodontech.de/autocompleter',
        'https://darmarit.org/searx/autocompleter',
        'https://searx.solusar.de/autocompleter',
        'https://suche.uferwerk.org/autocompleter',
        'https://search.trom.tf/autocompleter',
        'https://searx.devol.it/autocompleter',
        //Error 'https://recherche.catmargue.org/autocompleter',
        'https://searx.run/autocompleter',
        'https://searx.nakhan.net/autocompleter'
    ];
    private $keyword;

    public function __construct($keyword)
    {
        $this->keyword = $keyword;
    }

    public function run()
    {
        Timer::timerStart('timer');
        $this->keywords = [];
        $urls = $this->generateUrls();
        // On sépare les urls en X tableaux
        $urlsParts = array_chunk($urls, ceil((count($urls) / 1)));
        foreach($urlsParts as $k => $urlsPart) {
            foreach ($this->multiple_threads_request($urlsPart) as $response) {
                $data = json_decode($response, true);
                if (is_array($data) && count($data) >= 1) {
                    $this->keywords = array_merge($this->keywords, $data[1]);
                }
            }
        }

        Log::debug('[Total][' . count($this->keywords) . '] mots-clés trouvées - Temps : ' . (int)Timer::timerRead('timer') . 'ms');

    }

    public function toHtmlContent()
    {
        return [
            'url' => 'https://www.semantics.fr/' . $this->keyword,
            'title' => $this->keyword,
            'content' => implode('. ', $this->keywords)
        ];
    }

    public function getKeywords()
    {
        return $this->keywords;
    }

    private function multiple_threads_request($urls){
        Timer::timerStart('timer-download-url');

        $mh = curl_multi_init();
        $curl_array = array();
        foreach($urls as $i => $url){

            $curl_array[$i] = curl_init($url);
            \curl_setopt($curl_array[$i], CURLOPT_CONNECTTIMEOUT, 2);
            \curl_setopt($curl_array[$i], CURLOPT_TIMEOUT, 2);
            \curl_setopt($curl_array[$i], CURLOPT_RETURNTRANSFER, true);
            \curl_setopt($curl_array[$i], \CURLOPT_POST, 0);
            \curl_setopt($curl_array[$i], \CURLOPT_HTTPHEADER, ['cookie: language=fr;autocomplete=google']);
            curl_multi_add_handle($mh, $curl_array[$i]);

        }
        $running = NULL;
        do {
            curl_multi_exec($mh, $running);

            // a request was just completed -- find out which one
            while($done = curl_multi_info_read($mh))
            {
                $info = curl_getinfo($done['handle']);
                $infoMsg = '[' . (int)($info['total_time'] * 1000) . 'ms][' . $info['http_code'] . '] - ' . $info['url'];
                if ($info['http_code'] === 200) {
                    Log::info($infoMsg);
                } else {
                    Log::error($infoMsg);
                }

                if(isset($urls[$i + 1])) {
                    // start a new request (it's important to do this before removing the old one)
                    $ch = curl_init();
                    $options[CURLOPT_URL] = $urls[$i++];  // increment i
                    curl_setopt_array($ch,$options);
                    curl_multi_add_handle($mh, $ch);
                }

                // remove the curl handle that just completed
                curl_multi_remove_handle($mh, $done['handle']);
            }
        } while($running > 0);

        $res = array();
        foreach($urls as $i => $url) {
            $res[$url] = curl_multi_getcontent($curl_array[$i]);
            curl_multi_remove_handle($mh, $curl_array[$i]);
        }

        // foreach($urls as $i => $url) {
        //     curl_multi_remove_handle($mh, $curl_array[$i]);
        // }
        curl_multi_close($mh);

        return $res;
    }

    /**
     * Génération des urls suggest à télécharger
     */
    private function generateUrls()
    {
        $urls = [];
        foreach($this->generateKeywords() as $keyword) {
            $parameters = ['q' => $this->keyword . ' ' . $keyword];
            $urls[] = $this->randomSearXUrl() . '?' . http_build_query($parameters);
        }
        return $urls;
    }

    /**
     * Génération des mots-clés à rechercher
     */
    private function generateKeywords()
    {
        $questions = ['pourquoi', 'ou', 'comment', 'quel', 'quoi', 'qui', 'que\'est-ce', 'quand', 'que', 'quelle'];
        $prepositions = ['à', 'dans', 'par', 'pour', 'en', 'vers', 'avec', 'de', 'sans', 'sous', 'au'];
        $comparaisons = ['contre', 'et', 'vs', 'comme', 'ou'];
        $alphabet = range('a','z');

        $items = [''];
        $items = array_merge($prepositions, $items);
        $items = array_merge($comparaisons, $items);
        $items = array_merge($questions, $items);
        $items = array_merge($alphabet, $items);

        return $items;
    }

    /**
     * Détermine un moteur de recherche SearX aléatoire
     */
    private function randomSearXUrl()
    {
        return Self::URLS[rand(0, count(Self::URLS) - 1)];
    }
}

?>
