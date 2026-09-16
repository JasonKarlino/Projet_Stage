<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250929141134 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sujet ADD ue_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sujet ADD titre VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE sujet ADD date_creation TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('COMMENT ON COLUMN sujet.date_creation IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE sujet ADD CONSTRAINT FK_2E13599D62E883B1 FOREIGN KEY (ue_id) REFERENCES ue (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_2E13599D62E883B1 ON sujet (ue_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE sujet DROP CONSTRAINT FK_2E13599D62E883B1');
        $this->addSql('DROP INDEX IDX_2E13599D62E883B1');
        $this->addSql('ALTER TABLE sujet DROP ue_id');
        $this->addSql('ALTER TABLE sujet DROP titre');
        $this->addSql('ALTER TABLE sujet DROP date_creation');
    }
}
