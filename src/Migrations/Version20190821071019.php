<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190821071019 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE partenaire CHANGE nompartenaire nom_complet_p VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user ADD nom_complet_u VARCHAR(255) NOT NULL, DROP nom, DROP prenom');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE partenaire CHANGE nom_complet_p nompartenaire VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE user ADD prenom VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE nom_complet_u nom VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
