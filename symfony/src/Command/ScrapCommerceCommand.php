<?php

namespace App\Command;

use App\Entity\Price;
use App\Entity\Product;
use App\SourcesCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;

#[AsCommand(
    name: 'app:scrap-commerce',
    description: 'Add a short description for your command',
)]

class ScrapCommerceCommand extends Command
{
    private EntityManagerInterface $entityManager;
    private SourcesCollection $sourcesCollection;

    /**
     * @param EntityManagerInterface $entityManager
     * @param string|null $name
     */
    public function __construct(EntityManagerInterface $entityManager, SourcesCollection $sourcesCollection, string $name = null)
    {
        parent::__construct($name);
        $this->entityManager = $entityManager;
        $this->sourcesCollection = $sourcesCollection;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $client = HttpClient::create();
        $today = new \DateTimeImmutable();
        foreach ($this->sourcesCollection->getSources() as $source) {
            $output->write('Scraping from "' . $source->getName() . '"');
            $crawler = new Crawler($client->request('GET', $source->getUrl())->getContent());

            $productId = $source->extractItemIdFromHTML($crawler->filter($source->getItemIdSelector())->text());
            if (!($product = $this->entityManager->getRepository(Product::class)->find($productId))) {
                $output->write(' > Creating new product ' . $productId . '.');
                $product = new Product();
                $product
                    ->setItemId($productId)
                    ->setSource($source->getName());
            }

            $price = new Price();
            $price
                ->setAmount($source->extractPriceFromHTML(($crawler->filter($source->getPriceSelector())->text())))
                ->setDate($today);

            $output->writeln(' > Got price for today: "' . $price->getAmount() . '"');

            $product->addPrice($price);
            $this->entityManager->persist($product);
        }

        $this->entityManager->flush();

        $output->writeln('Products saved to the database');
        return Command::SUCCESS;
    }
}
