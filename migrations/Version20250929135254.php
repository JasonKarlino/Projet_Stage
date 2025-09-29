<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250929135254 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sujet ADD nbre_question INT NOT NULL');
        $this->addSql('ALTER TABLE sujet DROP niveau_difficulte');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE enseignant ALTER contact TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE sujet ADD niveau_difficulte VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE sujet DROP nbre_question');
    }
}
