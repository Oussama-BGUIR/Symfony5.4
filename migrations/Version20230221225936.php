<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230221225936 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fiche DROP FOREIGN KEY FK_4C13CC78E3E6550F');
        $this->addSql('DROP INDEX UNIQ_4C13CC78E3E6550F ON fiche');
        $this->addSql('ALTER TABLE fiche ADD date DATETIME NOT NULL, DROP rdvs_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fiche ADD rdvs_id INT DEFAULT NULL, DROP date');
        $this->addSql('ALTER TABLE fiche ADD CONSTRAINT FK_4C13CC78E3E6550F FOREIGN KEY (rdvs_id) REFERENCES rdv (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4C13CC78E3E6550F ON fiche (rdvs_id)');
    }
}
