<?php

namespace App\Sources;

use App\Scraper\Contracts\SourceInterface;

class Zones implements SourceInterface
{

    public function getUrl(): string
    {
        return "https://www.zones.com/site/product/index.html?id=109209216";
    }

    public function getName(): string
    {
        return "Zones";
    }

    public function getItemIdSelector(): string
    {
        return "#item_no_id";
    }

    public function getPriceSelector(): string
    {
        return "#body > div.container.ga_ec_p.pt-4 > div.row > div.col-12.col-md-7.col-xl-8.order-2 > div.row > ul.price-box-list.col-6.col-xl > li > div";
    }

    public function extractPriceFromHTML(string $html): float
    {
        return preg_replace('/[$,]/', '', $html);
    }

    public function extractItemIdFromHTML(string $html): string
    {
        return $html;
    }
}