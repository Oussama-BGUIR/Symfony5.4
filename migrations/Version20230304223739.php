<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230304223739 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE abonnement CHANGE prenom prenom VARCHAR(255) NOT NULL, CHANGE email email VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_AF86866FF483159E');
        $this->addSql('DROP INDEX IDX_AF86866FF483159E ON offre');
        $this->addSql('ALTER TABLE offre CHANGE abonnement_id_id abonnement_nom_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866F2A21A176 FOREIGN KEY (abonnement_nom_id) REFERENCES abonnement (id)');
        $this->addSql('CREATE INDEX IDX_AF86866F2A21A176 ON offre (abonnement_nom_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE abonnement CHANGE prenom prenom VARCHAR(20) NOT NULL, CHANGE email email VARCHAR(30) NOT NULL');
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_AF86866F2A21A176');
        $this->addSql('DROP INDEX IDX_AF86866F2A21A176 ON offre');
        $this->addSql('ALTER TABLE offre CHANGE abonnement_nom_id abonnement_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866FF483159E FOREIGN KEY (abonnement_id_id) REFERENCES abonnement (id)');
        $this->addSql('CREATE INDEX IDX_AF86866FF483159E ON offre (abonnement_id_id)');
    }
}
