<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230216015239 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE menu DROP image, CHANGE description description LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE plat DROP FOREIGN KEY FK_2038A207AA14E1C8');
        $this->addSql('DROP INDEX IDX_2038A207AA14E1C8 ON plat');
        $this->addSql('ALTER TABLE plat ADD menu_id INT DEFAULT NULL, DROP plats_id, DROP image, CHANGE description description LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE plat ADD CONSTRAINT FK_2038A207CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id)');
        $this->addSql('CREATE INDEX IDX_2038A207CCD7E912 ON plat (menu_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE menu ADD image VARCHAR(255) NOT NULL, CHANGE description description VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE plat DROP FOREIGN KEY FK_2038A207CCD7E912');
        $this->addSql('DROP INDEX IDX_2038A207CCD7E912 ON plat');
        $this->addSql('ALTER TABLE plat ADD plats_id INT NOT NULL, ADD image LONGTEXT NOT NULL COMMENT \'(DC2Type:object)\', DROP menu_id, CHANGE description description VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE plat ADD CONSTRAINT FK_2038A207AA14E1C8 FOREIGN KEY (plats_id) REFERENCES menu (id)');
        $this->addSql('CREATE INDEX IDX_2038A207AA14E1C8 ON plat (plats_id)');
    }
}
