<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230220191336 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, cin INT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, sexe VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, mdp VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE planning ADD id_c_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE planning ADD CONSTRAINT FK_D499BFF61AF787D1 FOREIGN KEY (id_c_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D499BFF61AF787D1 ON planning (id_c_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE planning DROP FOREIGN KEY FK_D499BFF61AF787D1');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP INDEX UNIQ_D499BFF61AF787D1 ON planning');
        $this->addSql('ALTER TABLE planning DROP id_c_id');
    }
}
