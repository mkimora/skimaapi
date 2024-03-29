<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190816131605 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE beneficiaire');
        $this->addSql('DROP TABLE expediteur');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE beneficiaire (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, prenom VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, telephone INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE expediteur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, prenom VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, telephone INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
    }
}
