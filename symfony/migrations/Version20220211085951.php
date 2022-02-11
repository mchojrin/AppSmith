<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220211085951 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE price (id INT AUTO_INCREMENT NOT NULL, product_id VARCHAR(255) NOT NULL, date DATE NOT NULL, amount NUMERIC(7, 2) NOT NULL, INDEX IDX_CAC822D94584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (item_id VARCHAR(255) NOT NULL, source LONGTEXT NOT NULL, PRIMARY KEY(item_id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE price ADD CONSTRAINT FK_CAC822D94584665A FOREIGN KEY (product_id) REFERENCES product (item_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE price DROP FOREIGN KEY FK_CAC822D94584665A');
        $this->addSql('DROP TABLE price');
        $this->addSql('DROP TABLE product');
    }
}
