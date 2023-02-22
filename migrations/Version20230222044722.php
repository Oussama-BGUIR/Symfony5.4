<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230222044722 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE menu ADD disponibilite TINYINT(1) NOT NULL, ADD calorie INT NOT NULL, ADD image VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE plat ADD disponibilte TINYINT(1) NOT NULL, ADD calorie INT NOT NULL, ADD image VARCHAR(255) NOT NULL, CHANGE prix prix NUMERIC(10, 0) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE menu DROP disponibilite, DROP calorie, DROP image');
        $this->addSql('ALTER TABLE plat DROP disponibilte, DROP calorie, DROP image, CHANGE prix prix DOUBLE PRECISION NOT NULL');
    }
}
