<?php


namespace App\Custom\Search;


class Searx
{

    private const URL = 'https://searx.laquadrature.net/?preferences=eJx9VU1v2zAM_TXzxeiwj8NOPgwbhhUY0GHtdhVoiXY4S6IryUndXz8qsV05KHaIEVMk39PjhyN0GBGCPjTvKg0Jew6EsenRYwBbwZRYsxstJmwqQxFai0aNdurJx-YPuRtLA6oDpwHn-ObDl7sRvQoYJ5uUJT9ExV55PKk28CliUAnaze-z1hij-np3KyGnQAnl5NZ35OWvijqwtZVlDRabLlSGKadme8TQMMjrWw59RQ56VGPgp7n5BjZihX7P8yGAHgT7968fksCxxAvQPdpOCRoHB4nYx7Mti5E5L2rMKqJFneTs-8PDz_uVaJV4QEldOUwHNs3Pu_uHKh3QYcNRQ6jOz5uYZuFuuSfNBo8bM_RCTIQ2kx7yr2elFtEF6fEEPpWGGQ784lFd9N2kFUmXi28VWvP7GUApN0XSkqYL4MBSG1ApyldiqULAkaNSHVnMClwizprm1yODMImsCWzt0BCIMaAxtCP4_qmIwcRsY3nsR7cgRnz24MozMxlphcLQM_cW69HCXJ-Zv1wAdB95KqB2vnyU3lXqSAY5HxrT1wbP3ZTLW2JorW_SsfA90SCCncQpP8-01srUF7QCFcahdhQCh-VWEp0hQNqlABlIDyD9vdGffBSm8VCkWqVcUB3_RRzKJOShoLkKsBnW-JeEUzv36OLC7FLOzR3T7NjLYGKJsSa5KrMhnZ5579pTstAuybuAWEfu0gkC1oaCDEoemcupm53MWpjrFMBHK_Nkdj1xZra2XdbfQIJX9VudWkqtlATTgqCnENDrneirQmtML3omcrgKInM7c-J44AH8VQPIXoiU9ulkHYi9pvgayFrYHNwyDzunbByzlKXxsm3zMqjzYyH1_uPHT08FmQO0AfLjpb9IAIPG_VbwBp9Ky9XlSnqPEyf8j--qF8qeJnN9jyPPecm-VpyNdEwQ0njlVg4ojGNRzM4EzkDbe5DPBYEup5t6WWcQd6sm7y8ZtDpbYlGWyoLvJ4mUT8U_pCqV9w==&format=json';
    private $query;

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function search()
    {
        return $this->searchWeb();
    }

    private function Download($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($ch, CURLOPT_USERAGENT, self::randomUserAgent());
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    private function searchWeb()
    {
        $results = [];
        $content = json_decode($this->Download(self::URL . '&q=' . urlencode($this->query)));

        if (!isset($content->results)) {
            return $results;
        }
        foreach ($content->results as $item) {
            if (!isset($item->url)) continue;
            $results[] = $item->url;
        }

        return array_unique($results);
    }
}
