<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211203164619 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD953C1C61');
        $this->addSql('DROP TABLE source');
        $this->addSql('DROP INDEX IDX_D34A04AD953C1C61 ON product');
        $this->addSql('ALTER TABLE product ADD source LONGTEXT NOT NULL, DROP source_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE source (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE product ADD source_id INT NOT NULL, DROP source');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD953C1C61 FOREIGN KEY (source_id) REFERENCES source (id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD953C1C61 ON product (source_id)');
    }
}
