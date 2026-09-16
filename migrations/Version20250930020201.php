<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250930020201 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql("UPDATE enseignant SET mot_de_passe = 'hash_temporaire_invalide' WHERE mot_de_passe IS NULL");
        $this->addSql('ALTER TABLE enseignant ALTER mot_de_passe SET NOT NULL');
        $this->addSql("UPDATE enseignant SET roles = '{}' WHERE roles IS NULL");
        $this->addSql('ALTER TABLE enseignant ALTER COLUMN roles SET NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE enseignant DROP mot_de_passe');
        $this->addSql('ALTER TABLE enseignant DROP roles');
    }
}
