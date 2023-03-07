<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230305155142 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE calendar (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, start DATETIME NOT NULL, end DATETIME NOT NULL, description LONGTEXT NOT NULL, all_day TINYINT(1) NOT NULL, background_color VARCHAR(7) NOT NULL, border_color VARCHAR(7) NOT NULL, text_color VARCHAR(7) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE fiche DROP FOREIGN KEY FK_4C13CC78E3E6550F');
        $this->addSql('DROP INDEX UNIQ_4C13CC78E3E6550F ON fiche');
        $this->addSql('ALTER TABLE fiche DROP rdvs_id, DROP duree, DROP date');
        $this->addSql('ALTER TABLE rdv DROP FOREIGN KEY FK_10C31F86E9756732');
        $this->addSql('DROP INDEX UNIQ_10C31F86E9756732 ON rdv');
        $this->addSql('ALTER TABLE rdv CHANGE fiches_id nom_nutritioniste_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rdv ADD CONSTRAINT FK_10C31F8616C78193 FOREIGN KEY (nom_nutritioniste_id) REFERENCES fiche (id)');
        $this->addSql('CREATE INDEX IDX_10C31F8616C78193 ON rdv (nom_nutritioniste_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE calendar');
        $this->addSql('ALTER TABLE fiche ADD rdvs_id INT DEFAULT NULL, ADD duree VARCHAR(255) NOT NULL, ADD date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE fiche ADD CONSTRAINT FK_4C13CC78E3E6550F FOREIGN KEY (rdvs_id) REFERENCES rdv (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4C13CC78E3E6550F ON fiche (rdvs_id)');
        $this->addSql('ALTER TABLE rdv DROP FOREIGN KEY FK_10C31F8616C78193');
        $this->addSql('DROP INDEX IDX_10C31F8616C78193 ON rdv');
        $this->addSql('ALTER TABLE rdv CHANGE nom_nutritioniste_id fiches_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rdv ADD CONSTRAINT FK_10C31F86E9756732 FOREIGN KEY (fiches_id) REFERENCES fiche (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_10C31F86E9756732 ON rdv (fiches_id)');
    }
}
