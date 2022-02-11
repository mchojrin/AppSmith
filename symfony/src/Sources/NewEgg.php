<?php

namespace App\Sources;

use App\Scraper\Contracts\SourceInterface;

class NewEgg implements SourceInterface
{
    public function getUrl(): string
    {
        return 'https://www.newegg.com/p/1TS-000D-0JG62';
    }

    public function getName(): string
    {
        return 'NewEgg';
    }

    public function getPriceSelector(): string
    {
        return '.price-current strong';
    }

    public function getItemIdSelector(): string
    {
        return 'ol.breadcrumb em';
    }


    /**
     * @param string $html
     * @return int
     */
    public function extractPriceFromHTML(string $html): float
    {
        return floatval(str_replace(',', '', $html));
    }

    /**
     * @param string $html
     * @return string
     */
    public function extractItemIdFromHTML(string $html): string
    {
        return $html;
    }
}
