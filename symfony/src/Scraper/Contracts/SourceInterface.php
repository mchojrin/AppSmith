<?php

namespace App\Scraper\Contracts;
interface SourceInterface extends \Stringable
{
    public function getUrl(): string;
    public function getName(): string;
    public function getWrapperSelector(): string;
    public function getDescriptionSelector(): string;
    public function getItemIdSelector(): string;
    public function getImageSelector(): string;
    public function getPriceSelector(): string;
}
