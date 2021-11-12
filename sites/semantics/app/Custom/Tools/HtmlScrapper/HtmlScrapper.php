<?php

namespace App\Custom\Tools\HtmlScrapper;

use GuzzleHttp\Psr7\Uri;
use Illuminate\Support\Facades\Log;
use Symfony\Component\DomCrawler\Crawler;

class HtmlScrapper extends HtmlScrapperFilters {

    /**
     * Constante des mots clés vides
     */
    private const STOPWORDS = [
        'afin','ainsi','alors','au','aucuns','aussi','autre','aux','avant','avec','avoir','bon','ça','car','ce','ceci','cela','celà','ces','est','cet','cette','ceux','chaque','ci','comme','comment','dans','debut','début','dedans','dehors','depuis','des','deux','devrait','doit','donc','dos','droite','du','un','une','egalement','elle','elles','en','encore','ensuite','es','essai','est','et','étaient','étais','était','étant','état','etc','ete','été','étée','étées','êtes','étés','étiez','étions','être','eu','eux','fait','faites','fois','font','force','fûmes','furent','fus','fusse','fussent','fusses','fussiez','fussions','fut','fût','fûtes','grace','grâce','haut','hors','ici','il','ils','ils4les','je','juste','la','là','le','les','leur','leurs','ma','maintenant','mais','meme','même','mes','mieux','mine','moins','mon','mot','ni','nommés','nos','notre','nous','nouveaux','ou','où','par','parce','parole','pas','personnes','peu','peut','pièce','plupart','pour','pourquoi','quand','que','quel','quelle','quelles','quels','qui','sa','sans','sera','serai','seraient','serais','serait','seras','serez','seriez','serions','serons','seront','ses','seulement','si','sien','soi','soient','sois','soit','sommes','son','sont','sous','soyez','soyons','suis','sujet','sur','ta','tandis','tellement','tels','tes','ton','tous','tout','toute','toutes','tres','très','trop','tu','un','une','valeur','voie','voient','vont','vos','votre','vous','vu'
    ];

    private const BALISESNEWLINE = ['h[1-6]', 'p', 'li', 'td'];
    private const BALISESSPACE = ['small', 'strong', 'b', 'br'];
    private const SPECIALCARACTERE = ['.', '?', '!'];

    /** @var String */
    protected $url;

    /** @var */
    protected $domain;

    /** @var String */
    protected $content;

    /**
     * HtmlParser constructor.
     * @param String $content
     * @param String $url
     */
    public function __construct(String $content, URi $uri)
    {
        $this->crawler = new Crawler($content, $uri);
        $this->uri = $uri;
        $this->url = (string)$uri;
        $this->domain = $uri->getHost();
        $this->content = $content;
    }

    public function run()
    {
        return [
            'links' => $this->linksWithDetails(),
            'images' => $this->imagesWithDetails(),
            'outline' => $this->outline(),
            'title' => $this->title(),
            'headings' =>  [
                'h1' => $this->h1(),
                'h2' => $this->h2(),
                'h3' => $this->h3(),
                'h4' => $this->h4(),
                'h5' => $this->h5(),
                'h6' => $this->h6(),
            ],
            'headers' => $this->headers(),
            'metaTags' => $this->metaTags(),
            'twitterCard' => $this->twitterCard(),
            'openGraph' => $this->openGraph()
        ];
    }

    /**
     * Get the title
     *
     * @return string
     */
    public function title()
    {
        return $this->filterFirstText('//title');
    }

    /**
     * Get the content-type
     *
     * @return string
     */
    public function contentType()
    {
        return $this->filterFirstExtractAttribute('//meta[@http-equiv="Content-type"]', ['content']);
    }

    /**
     * Get the canonical
     *
     * @return string
     */
    public function canonical()
    {
        return $this->filterFirstExtractAttribute('//link[@rel="canonical"]', ['href']);
    }

    /**
     * Get the viewport as a string
     *
     * @return string
     */
    public function viewportString()
    {
        return $this->filterFirstContent('//meta[@name="viewport"]');
    }

    /**
     * Get the viewport as an array
     *
     * @return array
     */
    public function viewport()
    {
        return is_null($this->viewportString()) ?
            [] : \preg_split('/,\s*/', $this->viewportString());
    }

    /**
     * Get the csrfToken
     *
     * @return string
     */
    public function csrfToken()
    {
        return $this->filterFirstExtractAttribute('//meta[@name="csrf-token"]', ['content']);
    }

    /**
     * Get the header collected as an array
     *
     * @return array
     */
    public function headers()
    {
        return [
            'contentType' => $this->contentType(),
            'viewport' => $this->viewport(),
            'canonical' => $this->canonical(),
            'csrfToken' => $this->csrfToken(),
        ];
    }

    /**
     * Get the author
     *
     * @return string
     */
    public function author()
    {
        return $this->filterFirstContent('//meta[@name="author"]');
    }

    /**
     * Get the image
     *
     * @return string
     */
    public function image()
    {
        return $this->filterFirstContent('//meta[@name="image"]');
    }

    /**
     * Get the keyword as a string
     *
     * @return string
     */
    public function keywordString()
    {
        return $this->filterFirstContent('//meta[@name="keywords"]');
    }

    /**
     * Get the keyword as an array
     *
     * @return array
     */
    public function keywords()
    {
        return is_null($this->keywordString()) ?
            [] : \preg_split('/,\s*/', $this->keywordString());
    }

    /**
     * Get the description
     *
     * @return string
     */
    public function description()
    {
        return $this->filterFirstContent('//meta[@name="description"]');
    }

    /**
     * Get the meta collected as an array
     *
     * @return array
     */
    public function metaTags()
    {
        return [
            'author' => $this->author(),
            'image' => $this->image(),
            'keywords' => $this->keywords(),
            'description' => $this->description(),
        ];
    }

    /**
     * Gets the open graph attributes as an array
     *
     * @return array
     */
    public function twitterCard()
    {
        $data = $this
            ->filter('//meta[contains(@name, "twitter:")]')
            ->extract(['name', 'content']);

        // Prepare the data
        $result = [];
        foreach ($data as $set) {
            $result[$set[0]] = $set[1];
        }

        return $result;
    }

    /**
     * Gets the open graph attributes as an array
     *
     * @return array
     */
    public function openGraph()
    {
        $data = $this
            ->filter('//meta[contains(@property, "og:")]')
            ->extract(['property', 'content']);

        // Prepare the data
        $result = [];
        foreach ($data as $set) {
            $result[$set[0]] = $set[1];
        }

        return $result;
    }

    /**
     * Get all <h1> tags (should be usually only one)
     *
     * @return array
     */
    public function h1()
    {
        return $this->filterExtractAttributes('//h1', ['_text']);
    }

    /**
     * Get all <h2> tags
     *
     * @return array
     */
    public function h2()
    {
        return $this->filterExtractAttributes('//h2', ['_text']);
    }

    /**
     * Get all <h3> tags
     *
     * @return array
     */
    public function h3()
    {
        return $this->filterExtractAttributes('//h3', ['_text']);
    }

    /**
     * Get all <h4> tags
     *
     * @return array
     */
    public function h4()
    {
        return $this->filterExtractAttributes('//h4', ['_text']);
    }

    /**
     * Get all <h5> tags
     *
     * @return array
     */
    public function h5()
    {
        return $this->filterExtractAttributes('//h5', ['_text']);
    }

    /**
     * Get all <h6> tags
     *
     * @return array
     */
    public function h6()
    {
        return $this->filterExtractAttributes('//h6', ['_text']);
    }

    /**
     * Get all heading tags
     *
     * @return array
     */
    public function headings()
    {
        return [
            $this->h1(),
            $this->h2(),
            $this->h3(),
            $this->h4(),
            $this->h5(),
            $this->h6(),
        ];
    }

    /**
     * Parses the content outline of the web-page
     *
     * @return array
     */
    public function outline()
    {
        $result = $this->filterExtractAttributes('//h1|//h2|//h3|//h4|//h5|//h6', ['_name', '_text']);

        foreach ($result as $index => $array) {
            $result[$index] = array_combine(['tag', 'content'], $array);
        }

        return $result;
    }

    /**
     * Get all links on the page as absolute URLs
     *
     * @see https://github.com/spekulatius/link-scraping-test-beautifulsoup-vs-phpscraper
     *
     * @return array
     */
    public function links()
    {
        $links = $this->filter('//a')->links();

        // Generate a list of all image entries
        $result = [];
        foreach ($links as $link) {
            $result[] = $link->getUri();
        }

        return $result;
    }

        /**
     * Get all links on the page with commonly interesting details
     *
     * @return array
     */
    public function linksWithDetails()
    {
        $links = $this->filter('//a');

        $linksCount = array_count_values($this->links());

        // Generate a list of all image entries
        $result = [];
        foreach ($links as $link) {
            // Generate the proper uri using the Symfony's link class
            $linkObj = new \Symfony\Component\DomCrawler\Link($link, $this->uri);

            // Check if the anchor is maybe only an image.
            $image = [];
            foreach($link->childNodes as $childNode) {
                if (!empty($childNode) && $childNode->nodeName === 'img') {
                    $image[] = (new \Symfony\Component\DomCrawler\Image($childNode, $this->uri))->getUri();
                }
            }

            // Collect commonly interesting attributes and URL
            $entry = [
                'url' => $linkObj->getUri(),
                'text' => trim($link->nodeValue),
                'title' => $link->getAttribute('title') == '' ? null : $link->getAttribute('title'),
                'target' => $link->getAttribute('target') == '' ? null : $link->getAttribute('target'),
                'rel' => $link->getAttribute('rel') == '' ? null : strtolower($link->getAttribute('rel')),
                'image' => $image,
                // 'type' => ($this->uri->getHost() === $linkObjSpatie->getHost()) ? 'internal' : 'external',
                'count' => $linksCount[$linkObj->getUri()] ?? 1
            ];

            $result[] = $entry;
        }

        return $result;
    }

    /**
     * Get all images on the page with absolute URLs
     *
     * @return array
     */
    public function images()
    {
        $images = $this->filter('//img')->images();

        // Generate a list of all image entries
        $result = [];
        foreach ($images as $image) {
            $result[] = $image->getUri();
        }

        return $result;
    }

    /**
     * Get all images on the page with commonly interesting details
     *
     * @return array
     */
    public function imagesWithDetails()
    {
        $images = $this->filter('//img');

        // Generate a list of all image entries
        $result = [];
        foreach ($images as $image) {
            // Generate the proper uri using the Symfony's image class
            $imageObj = new \Symfony\Component\DomCrawler\Image($image, $this->uri);

            // Collect commonly interesting attributes and URL
            $result[] = [
                'url' => $imageObj->getUri(),
                'alt' => $image->getAttribute('alt'),
                'width' => $image->getAttribute('width') == '' ? null : $image->getAttribute('width'),
                'height' => $image->getAttribute('height') == '' ? null : $image->getAttribute('height'),
            ];
        }

        return $result;
    }

    public function getFullContent()
    {
        $this->removeBalisesContent(['script', 'style']);
        $text = $this->crawler->filterXpath('//body')->html();
        foreach (SELF::BALISESNEWLINE as $balise) {
            $text = preg_replace ('/<' .$balise .'>/', ".\n", $text);
        }

        foreach (SELF::BALISESSPACE as $balise) {
            $text = preg_replace ('/<' .$balise .'>/', " ", $text);
        }

        foreach (SELF::SPECIALCARACTERE as $caractere) {
            $text = str_replace ($caractere, $caractere ."\n", $text);
        }

        $text = strip_tags($text); // Remove all HTML tags
        $text = html_entity_decode($text); // Make sure we have no HTML entities left over

        $text = str_replace("\t", " ", $text); // Replace tabs with spaces
        $text = preg_replace('/ {2,}/', ' ', $text); // Remove multiple spaces

        $text = str_replace("\r", "\n", $text); // convert carriage returns to newlines
        $text = preg_replace("/(\n)+/", "$1", $text); // remove excessive line returns
        $text = trim($text);

        $text = str_replace('’', '\'', $text);


        $items = explode("\n", $text);
        $items = $this->getUsefullText($items);
        return $items;
    }

    protected function getUsefullText($items)
    {
        // Suppression des phrases non pertinentes
        foreach ($items as $k => $item) {
            // Elimination chaines vides ou trop courtes
            if ($item === "" || strlen($item ) <= 15) {
                unset($items[$k]);
                continue;
            }

            // Elimination chaines ne contenant pas de français
            $hasStopword = false;
            $lower = ' ' . strtolower($item);
            foreach (self::STOPWORDS as $stopWord) {
                if (preg_match("/\\s$stopWord\s/", $lower) !== 0 ) {
                    $hasStopword = true;
                    break;
                }
            }
            if (!$hasStopword) {
                unset($items[$k]);
                continue;
            }
            $items[$k] = trim($items[$k]);
            $items[$k] = trim($items[$k], '.');
            $stripped = preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $items[$k]);
            $items[$k] = $stripped;
        }
        return $items;
    }

    /**
     * Parses the content outline of the web-page
     *
     * @return array
     */
    public function getLightContent($attributes = ['h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'p'], $withDesciption = true, $withLinks = true, $withImages = true)
    {
        $items = [];

        // Ajout de la description
        if ($withDesciption) {
            $items[] = $this->description();
        }

        // Ajout balises Hx, P et li
        $items = array_merge($items, $this->filterExtractAttributes('//' . implode('|//', $attributes), ['_text']));

        // Ajout links texte
        if ($withLinks) {
            foreach ($this->linksWithDetails() as $link) {
                $items[] = $link['text'];
                $items[] = $link['title'];
            }
        }

        // Ajout images texte
        if ($withImages) {
            foreach ($this->imagesWithDetails() as $image) {
                $items[] = $image['alt'];
            }
        }

         // Suppression des doublons
         $items = array_unique($items);

         $items = $this->getUsefullText($items);

        return $items;
    }

    public function getFullContentText()
    {
        return $this->contentToText($this->getFullContent(), 10000);
    }

    public function getLightContentText()
    {
        return $this->contentToText($this->getLightContent(['h1', 'h2', 'h3', 'p'], false, false, false), 1500);
    }

    public function contentToText($phrases, $max = 10000) {
        $content = '';
        foreach($phrases as $phrase) {
            if ($content === '') {
                $content .= $phrase;
            } else {
                $content .= '. ' . $phrase;
            }
            if (strlen($content) > $max) {
                break;
            }
        }
        return $content;
        return implode('. ', $this->getLightContent());
    }

    protected function removeBalisesContent($balises)
    {
        foreach ($balises as $balise) {
            $this->crawler->filter($balise)->each(function (Crawler $crawler) {
                foreach ($crawler as $node) {
                    $node->parentNode->removeChild($node);
                }
            });
        }
    }
}

?>
