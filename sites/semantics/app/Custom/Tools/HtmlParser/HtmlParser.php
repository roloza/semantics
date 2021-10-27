<?php

namespace App\Custom\Tools\HtmlParser;

use GuzzleHttp\Psr7\Uri;
use Symfony\Component\DomCrawler\Crawler;
// https://efficaceweb.fr/articles/balises-html-pour-le-referencement-google-comment-les-utiliser/
// https://www.unarticlepourleweb.fr/les-balises-html-en-redaction-web/

class HtmlParser
{
    /** @var Crawler */
    protected $crawler;


    /** @var String */
    protected $url;
    /** @var */
    protected $domain;

    /** @var String */
    protected $content;

    protected $uri;

    /**
     * Constante des mots clés vides
     */
    private const STOPWORDS = [
        'afin','ainsi','alors','au','aucuns','aussi','autre','aux','avant','avec','avoir','bon','ça','car','ce','ceci','cela','celà','ces','est','cet','cette','ceux','chaque','ci','comme','comment','dans','debut','début','dedans','dehors','depuis','des','deux','devrait','doit','donc','dos','droite','du','un','une','egalement','elle','elles','en','encore','ensuite','es','essai','est','et','étaient','étais','était','étant','état','etc','ete','été','étée','étées','êtes','étés','étiez','étions','être','eu','eux','fait','faites','fois','font','force','fûmes','furent','fus','fusse','fussent','fusses','fussiez','fussions','fut','fût','fûtes','grace','grâce','haut','hors','ici','il','ils','ils4les','je','juste','la','là','le','les','leur','leurs','ma','maintenant','mais','meme','même','mes','mieux','mine','moins','mon','mot','ni','nommés','nos','notre','nous','nouveaux','ou','où','par','parce','parole','pas','personnes','peu','peut','pièce','plupart','pour','pourquoi','quand','que','quel','quelle','quelles','quels','qui','sa','sans','sera','serai','seraient','serais','serait','seras','serez','seriez','serions','serons','seront','ses','seulement','si','sien','soi','soient','sois','soit','sommes','son','sont','sous','soyez','soyons','suis','sujet','sur','ta','tandis','tellement','tels','tes','ton','tous','tout','toute','toutes','tres','très','trop','tu','un','une','valeur','voie','voient','vont','vos','votre','vous','vu'
    ];

    private const BALISESNEWLINE = ['h[1-6]', 'p', 'li', 'td'];
    private const BALISESSPACE = ['small', 'strong', 'b', 'br'];
    private const SPECIALCARACTERE = ['.', '?', '!'];

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

    public function analyse()
    {
        $commons = [
            'title'     => $this->getBalisesText('title'),
            'description' => $this->getMetaContents('description'),
            'keywords' => $this->getMetaContents('keywords'),
            'openGraph' => $this->getOpenGraph(),
            'twitter' => $this->getTwitter(),
            'itemprop' => $this->getItemprop(),
            'viewport' => $this->getMetaContents('viewport'),
            'contentLanguage' => $this->getContentLanguage(),
            'contentType' => $this->getContentType(),
            'canonical' => $this->getCanonical(),
            'h1'        => $this->getBalisesText('h1'),
            'h2'        => $this->getBalisesText('h2'),
            'h3'        => $this->getBalisesText('h3'),
            'p'        => $this->getBalisesText('p'),
            'li'        => $this->getBalisesText('li'),
            'links'     => $this->getLinks(),
            'images'    => $this->getImages(),
            'styles'    => $this->getStyles(),
            'scripts'   => $this->getSscripts(),
            'robots'     => $this->getMetaContents('robots')
        ];

        return [
            'infos' => [
                'url' => $this->url,
                'domain' => $this->domain,
                'content' => $this->getFullContent(),
                'content-light' => $this->getLightContent()
            ],
            'commons'   => $commons,

        ];
    }

    public function getLightContent()
    {
        $balises = ['h1', 'h2', 'h3', 'h4', 'h5'];
        $metas = ['description', 'keywords'];
        $content = [];

        foreach ($metas as $meta) {
            $metaContents = $this->getMetaContents($meta);
            if (!empty($metaContents)) {
                foreach ($metaContents as $metaContent) {
                    $content[] = $metaContent;
                }
            }
        }

        foreach ($balises as $balise) {
            $baliseContents = $this->getBalisesText($balise);
            if (!empty($baliseContents)) {
                foreach ($baliseContents as $baliseContent) {
                    $content[] = $baliseContent;
                }
            }
        }

        return $content;
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
        foreach ($items as $k => $item) {
            $hasStopword = false;
            $lower = ' ' . strtolower($item);
            foreach (self::STOPWORDS as $stopWord) {
                if (preg_match("/\\s$stopWord\s/", $lower) !== 0 ) {
                    $hasStopword = true;
                    break;
                }
            }
            if (!$hasStopword || $item === "" || strlen($item ) <= 5) {
                unset($items[$k]);
            } else {
                $items[$k] = trim($items[$k]);
                $items[$k] = trim($items[$k], '.');
            }
        }
        return $items;
    }

    public function getFullContentText() {
        return implode('. ', $this->getFullContent());
    }

    public function getLightContentText() {
        return implode('. ', $this->getLightContent());
    }

    public function getTitle()
    {
        return current($this->getBalisesText('title'));
    }

    protected function getBalisesText($baliseName, $container = null) {
        try {
            if ($container) {
                return $container->filter($baliseName)->each(function ($node, $i) {
                    return self::cleanCell($node->text());
                });
            } else {
                return $this->crawler->filter($baliseName)->each(function ($node, $i) {
                    return self::cleanCell($node->text());
                });
            }
        } catch (\Exception $e) {
            return [];
        }
    }

    protected function getLinks() {
        try {
            $links = $this->crawler->filter('a')->each(function ($node, $i) {
                $href = $node->attr('href');
                if (strpos($href, $this->uri->getScheme()) !== 0) {
                    if (strpos($href, '/') === 0) {
                        $href =  $this->uri->getScheme(). '://' . $this->domain . $href;
                    } else {
                        $href = $this->uri->getScheme() . '://' . $this->domain . '/' . $href;
                    }
                }
                return new Link([
                    'href' => $href,
                    'title' => $node->attr('title'),
                    'target' => $node->attr('target'),
                    'rel' => $node->attr('rel'),
                    'text' => $node->text(),
                    'type' => (strpos($href, $this->uri->getScheme(). '://' . $this->domain) === 0) ? 'internal' : 'external',
                    'count' => 1
                ]);
            });

            $knowLinks = [];
            $total = sizeof($links);
            foreach ($links as $k => $link) {

                // Si le lien existe déja, on le supprimer et ajoute +1 au compteur du lien similaire existant
                if (in_array($link->getHref(), $knowLinks)) {
                    unset($links[$k]);
                    foreach ($links as $k2 => $link2) {
                        if ($link->getHref() === $link2->getHref()) {
                            $links[$k2]->setCount((int)$links[$k2]->getCount() + 1);
                        }
                    }
                } else {
                    $knowLinks[] = $link->getHref();
                }
            }
            return [
                'links' => $links,
                'total' => $total
            ];
        } catch (\Exception $e) {
            return [];
        }
    }

    protected function getImages() {
        try {
            $images = $this->crawler->filter('img')->each(function ($node, $i) {

                return new Image([
                    'src' => $node->attr('src'),
                    'name' => $node->attr('name'),
                    'count' => 1
                ]);
            });

            $knowLinks = [];
            foreach ($images as $k => $image) {

                // Si l'image existe déja, on la supprimer et ajoute +1 au compteur de l'image similaire existante
                if (in_array($image->getSrc(), $knowLinks)) {
                    unset($images[$k]);
                    foreach ($images as $k2 => $image2) {
                        if ($image->getSrc() === $image2->getSrc()) {
                            $images[$k2]->setCount((int)$images[$k2]->getCount() + 1);
                        }
                    }
                } else {
                    $knowLinks[] = $image->getSrc();
                }
            }
            return $images;
        } catch (\Exception $e) {
            return [];
        }
    }

    protected function getMetaContents($name, $label = 'name', $attr = 'content')
    {
        try {
            return $this->crawler->filter('meta[' . $label . '="' . $name . '"]')->each(function ($node, $i) use ($attr) {
                return self::cleanCell($node->attr($attr));
            });

            } catch (\Exception $e) {
            return [];
        }
    }

    protected function getOpenGraph()
    {
        $openGraph = [];
        $balises = ['og:title', 'og:description', 'og:url', 'og:image', 'og:site_name'];
        foreach ($balises as $balise) {
            $openGraph[$balise] = $this->getMetaContents($balise, 'property');
        }
        return $openGraph;
    }

    protected function getTwitter()
    {
        $openGraph = [];
        $balises = ['twitter:card', 'twitter:site', 'twitter:creator', 'twitter:title', 'twitter:description', 'twitter:image'];
        foreach ($balises as $balise) {
            $openGraph[$balise] = $this->getMetaContents($balise, 'name');
        }
        return $openGraph;
    }

    protected function getItemprop()
    {
        $openGraph = [];
        $balises = ['name', 'description', 'image'];
        foreach ($balises as $balise) {
            $openGraph[$balise] = $this->getMetaContents($balise, 'itemprop');
        }
        return $openGraph;
    }

    protected function getContentLanguage()
    {
        return $this->getMetaContents('content-language', 'http-equiv');
    }

    protected function getContentType()
    {
        return $this->getMetaContents('content-type', 'http-equiv');
    }

    protected function getCanonical()
    {
        try {
            return $this->crawler->filter('link[rel="canonical"]')->each(function ($node, $i) {
                return self::cleanCell($node->attr('href'));
            });

        } catch (\Exception $e) {
            return [];
        }
    }

    protected function getStyles()
    {
        try {
            $styles =  $this->crawler->filter('link[rel="stylesheet"]')->each(function ($node, $i) {
                return $node->attr('href');
            });

        } catch (\Exception $e) {
            return [];
        }
        foreach ($styles as $k => $style) {
            if ($style === null) {
                unset($styles[$k]);
            }
        }
        return $styles;
    }

    protected function getSscripts()
    {
        try {
            $scripts =  $this->crawler->filter('script')->each(function ($node, $i) {
                return $node->attr('src');
            });

        } catch (\Exception $e) {
            return [];
        }
        foreach ($scripts as $k => $script) {
            if ($script === null) {
                unset($scripts[$k]);
            }
        }
        return $scripts;
    }

    protected static  function cleanCell($str) {
        $str = preg_replace('# +#', ' ', $str);
        $str = str_replace(array("\r\n", "\n", "\r", "\t"), ".", $str);
        $str = str_replace(" .", ".", $str);
        $str = preg_replace('(\.{2,})', '. ', $str);
        $str = str_replace("’", "'", $str);
        $str = str_replace(["“", "”"], '"', $str);
        $str = str_replace("•", '.', $str);
        return trim($str, " ");
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
