#!/usr/bin/env php
<?php
require __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\SingleCommandApplication;
use App\Scraper\Scraper;
use App\Sources\TigerDirect;
use Symfony\Component\HttpClient\HttpClient;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Dotenv\Dotenv;

$env = new Dotenv();
$env->load('.env', '.env.local');

$entitiesPaths = array(__DIR__ . '/src/Entity');
$config = Setup::createAnnotationMetadataConfiguration(
    $entitiesPaths,
    true,
    null,
    null,
    false
);

$em = EntityManager::create([
    'url' => $_ENV['DATABASE_URL']
], $config);


(new SingleCommandApplication())
    ->setName('Scrap e-Commerce') // Optional
    ->setCode(function (InputInterface $input, OutputInterface $output) use ($em) {
        $output->writeln('Scrapping from two eCommerce sites');
        $sources = [
            new TigerDirect(),
        ];

        $scraper = new Scraper(HttpClient::create());
        foreach ($sources as $source) {
            $output->writeln('Scraping from ' . $source);
            $products = $scraper->scrap($source);
            $output->writeln('Found ' . $products->count() . ' products:');
        }

        foreach ($products as $product) {
            $em->persist($product);
        }

        $em->flush();
    })
    ->run();