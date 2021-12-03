<?php

namespace App\Sources;

use App\Scraper\Contracts\SourceInterface;

class TigerDirect implements SourceInterface
{
    public function getUrl(): string
    {
        return 'https://www.tigerdirect.com/applications/category/category_tlc.asp?CatId=17';
    }

    public function getName(): string
    {
        return 'TigerDirect';
    }

    public function getWrapperSelector(): string
    {
        return 'div.each-sku';
    }

    public function getDescriptionSelector(): string
    {
        return 'span.sku-name';
    }

    public function getImageSelector(): string
    {
        return 'span.sku-img img';
    }

    public function __toString(): string
    {
        return $this->getName();
    }

    public function getPriceSelector(): string
    {
        return 'span.d-price';
    }

    public function getItemIdSelector(): string
    {
        return 'span.sku-name';
    }
}
