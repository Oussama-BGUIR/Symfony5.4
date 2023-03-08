<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230219195723 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categorie ADD description VARCHAR(255) NOT NULL, ADD image VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE produit ADD description VARCHAR(255) NOT NULL, CHANGE categorie_id categorie_id INT DEFAULT NULL, CHANGE prix prix DOUBLE PRECISION NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categorie DROP description, DROP image');
        $this->addSql('ALTER TABLE produit DROP description, CHANGE categorie_id categorie_id INT NOT NULL, CHANGE prix prix INT NOT NULL');
    }
}
