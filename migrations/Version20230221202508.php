<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230221202508 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE fiche (id INT AUTO_INCREMENT NOT NULL, rdvs_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, date DATETIME NOT NULL, duree INT NOT NULL, description LONGTEXT NOT NULL, UNIQUE INDEX UNIQ_4C13CC78E3E6550F (rdvs_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rdv (id INT AUTO_INCREMENT NOT NULL, fiches_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, date DATETIME NOT NULL, description LONGTEXT NOT NULL, UNIQUE INDEX UNIQ_10C31F86E9756732 (fiches_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE fiche ADD CONSTRAINT FK_4C13CC78E3E6550F FOREIGN KEY (rdvs_id) REFERENCES rdv (id)');
        $this->addSql('ALTER TABLE rdv ADD CONSTRAINT FK_10C31F86E9756732 FOREIGN KEY (fiches_id) REFERENCES fiche (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fiche DROP FOREIGN KEY FK_4C13CC78E3E6550F');
        $this->addSql('ALTER TABLE rdv DROP FOREIGN KEY FK_10C31F86E9756732');
        $this->addSql('DROP TABLE fiche');
        $this->addSql('DROP TABLE rdv');
    }
}
