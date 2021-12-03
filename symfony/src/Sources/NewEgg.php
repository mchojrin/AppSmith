<?php

namespace App\Sources;

use App\Scraper\Contracts\SourceInterface;

class NewEgg implements SourceInterface
{
    public function getUrl(): string
    {
        return 'https://www.newegg.com/Laptops-Notebooks/Category/ID-223?cm_sp=Tab_Computer-Systems_1-_-VisNav-_-Laptop-Notebooks_2';
    }

    public function getName(): string
    {
        return 'NewEgg';
    }

    public function getWrapperSelector(): string
    {
        return 'div.item-cell';
    }

    public function getDescriptionSelector(): string
    {
        return 'a.item-title';
    }

    public function getImageSelector(): string
    {
        return 'a.item-img img';
    }

    public function __toString(): string
    {
        return $this->getName();
    }

    public function getPriceSelector(): string
    {
        return 'li.price-current strong';
    }

    public function getItemIdSelector(): string
    {
        return 'ul.item-features li:nth-child(4)';
    }
}
