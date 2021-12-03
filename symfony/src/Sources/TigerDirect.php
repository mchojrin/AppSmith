<?php

namespace App\Sources;

use App\Scraper\Contracts\SourceInterface;

class TigerDirect implements SourceInterface
{
    public function getUrl(): string
    {
        return 'https://www.tigerdirect.com/applications/category/category_slc.asp?Recs=10&Nav=|c:2627|&Sort=4';
    }

    public function getName(): string
    {
        return 'TigerDirect';
    }

    public function getWrapperSelector(): string
    {
        return '.each-sku';
    }

    public function getDescriptionSelector(): string
    {
        return 'a.sku-namecategory';
    }
    public function getLinkSelector(): string
    {
        return 'div.text-content a:nth-child(2)';
    }

    public function getImageSelector(): string
    {
        return 'a.itemImage img';
    }

    public function __toString(): string
    {
        return $this->getName();
    }

    public function getPriceSelector(): string
    {
        return 'p.price';
    }
}
