<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230216002707 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE plat DROP FOREIGN KEY FK_2038A2073256915B');
        $this->addSql('DROP INDEX IDX_2038A2073256915B ON plat');
        $this->addSql('ALTER TABLE plat ADD plats_id INT NOT NULL, DROP relation_id, CHANGE image image LONGTEXT NOT NULL COMMENT \'(DC2Type:object)\'');
        $this->addSql('ALTER TABLE plat ADD CONSTRAINT FK_2038A207AA14E1C8 FOREIGN KEY (plats_id) REFERENCES menu (id)');
        $this->addSql('CREATE INDEX IDX_2038A207AA14E1C8 ON plat (plats_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE plat DROP FOREIGN KEY FK_2038A207AA14E1C8');
        $this->addSql('DROP INDEX IDX_2038A207AA14E1C8 ON plat');
        $this->addSql('ALTER TABLE plat ADD relation_id INT DEFAULT NULL, DROP plats_id, CHANGE image image VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE plat ADD CONSTRAINT FK_2038A2073256915B FOREIGN KEY (relation_id) REFERENCES menu (id)');
        $this->addSql('CREATE INDEX IDX_2038A2073256915B ON plat (relation_id)');
    }
}
