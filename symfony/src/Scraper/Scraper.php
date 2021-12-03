<?php

namespace App\Scraper;

use App\Entity\Price;
use App\Entity\Product;
use App\Scraper\Contracts\SourceInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Scraper
{
    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function scrap(SourceInterface $source): Collection
    {
        $collection = [];
        $client = $this->client;
        $crawler = new Crawler($client->request('GET', $source->getUrl())->getContent());

        $today = new \DateTimeImmutable();

        $crawler
            ->filter($source->getWrapperSelector())
            ->each(function (Crawler $c) use ($source, &$collection, $today) {
                $product = new Product();

                $product->setDescription($c->filter($source->getDescriptionSelector())->text());
                $product->setItemId($c->filter($source->getItemIdSelector())->text());
                $product->setSource(get_class($source));

                $price = new Price();
                $price
                    ->setDate($today)
                    ->setAmount(($c->filter($source->getPriceSelector())->text()))
                ;

                $product->addPrice($price);

                $collection[] = $product;
            });

        return new ArrayCollection($collection);
    }

    /**
     * In order to make DateTime work, we need to clean up the input.
     *
     * @throws \Exception
     */
    private function cleanupDate(string $dateTime): \DateTime
    {
        $dateTime = str_replace(['(', ')', 'UTC', 'at', '|'], '', $dateTime);

        return new \DateTime($dateTime);
    }
}