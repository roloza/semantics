<?php

namespace App\Custom\Tools\HtmlScrapper;

use Symfony\Component\DomCrawler\Crawler;

class HtmlScrapperFilters {

    public $crawler;

    public function __construct(Crawler $crawler)
    {
        $this->crawler = $crawler;
    }

    /**
     * Filters the current page by a parameter
     *
     * @param string $filter
     * @return Crawler
     */
    public function filter(string $query)
    {
        return $this->crawler->filterXPath($query);
    }

    /**
     * Filters the current page by a parameter and returns the first one, or null.
     *
     * @param string $filter
     * @return Crawler|null
     */
    public function filterFirst(string $query)
    {
        $filtered = $this->filter($query);

        return ($filtered->count() == 0) ? null : $filtered->first();
    }

    /**
     * Filters the current page by a parameter and returns the first ones content, or null.
     *
     * @param string $filter
     * @return string|null
     */
    public function filterFirstText(string $query)
    {
        $filtered = $this->filter($query);

        return ($filtered->count() == 0) ? null : $filtered->first()->text();
    }

    /**
     * Filters the current page by a parameter and returns the first ones content, or null.
     *
     * @param string $filter
     * @param array $attributes
     * @return string|null
     */
    public function filterExtractAttributes(string $query, array $attributes)
    {
        $filtered = $this->filter($query);

        return ($filtered->count() == 0) ? [] : $filtered->extract($attributes);
    }

    /**
     * Filters the current page by a parameter and returns the first ones content, or null.
     *
     * @param string $filter
     * @param array $attributes
     * @return string|null
     */
    public function filterFirstExtractAttribute(string $query, array $attributes)
    {
        $filtered = $this->filter($query);

        return ($filtered->count() == 0) ? null : $filtered->first()->extract($attributes)[0];
    }

    /**
     * Returns the content attribute for the first result of the query, or null.
     *
     * @param string $filter
     * @return string|null
     */
    public function filterFirstContent(string $query)
    {
        return $this->filterFirstExtractAttribute($query, ['content']);
    }
}