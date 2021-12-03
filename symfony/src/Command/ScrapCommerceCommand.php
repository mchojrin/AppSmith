<?php

namespace App\Command;

use App\Sources\NewEgg;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Scraper\Scraper;
use App\Sources\TigerDirect;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\DomCrawler;

#[AsCommand(
    name: 'app:scrap-commerce',
    description: 'Add a short description for your command',
)]
class ScrapCommerceCommand extends Command
{
    private EntityManagerInterface $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     * @param string|null $name
     */
    public function __construct(EntityManagerInterface $entityManager, string $name = null)
    {
        parent::__construct($name);
        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $output->writeln('Scrapping from eCommerce sites');
        $sources = [
            new NewEgg(),
        ];

        $scraper = new Scraper(HttpClient::create());
        foreach ($sources as $source) {
            $output->writeln('Scraping from ' . $source);
            $products = $scraper->scrap($source);
            $output->writeln('Found ' . $products->count() . ' products:');
        }

        foreach ($products as $product) {
            $this->entityManager->persist($product);
        }

        $this->entityManager->flush();

        return Command::SUCCESS;
    }
}
