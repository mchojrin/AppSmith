<?php

namespace App\Sources;

use App\Scraper\Contracts\SourceInterface;

class TigerDirect implements SourceInterface
{
    public function getUrl(): string
    {
        return 'https://www.tigerdirect.com/applications/SearchTools/item-details.asp?EdpNo=1068054&CatId=11871&csid=_86';
    }

    public function getName(): string
    {
        return 'TigerDirect';
    }

    public function getPriceSelector(): string
    {
        return 'p.final-price > span.sale-price > span:nth-child(2)';
    }

    public function getItemIdSelector(): string
    {
        return '#mainC > section > div > div.bc_container > ul > li:nth-child(3)';
    }

    public function extractPriceFromHTML(string $html): float
    {
        return floatval(str_replace(',', '', $html));
    }

    public function extractItemIdFromHTML(string $html): string
    {
        return $html;
    }
}
