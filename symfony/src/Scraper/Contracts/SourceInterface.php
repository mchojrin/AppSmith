<?php

namespace App\Scraper\Contracts;

interface SourceInterface
{
    public function getUrl(): string;
    public function getName(): string;
    public function getItemIdSelector(): string;
    public function getPriceSelector(): string;
    public function extractPriceFromHTML(string $html): float;
    public function extractItemIdFromHTML(string $html): string;
}
