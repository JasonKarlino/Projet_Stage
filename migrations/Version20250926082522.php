<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250926082522 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ue ADD enseignant_id INT NOT NULL');
        $this->addSql('ALTER TABLE ue ADD CONSTRAINT FK_2E490A9BE455FCC0 FOREIGN KEY (enseignant_id) REFERENCES enseignant (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_2E490A9BE455FCC0 ON ue (enseignant_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE ue DROP CONSTRAINT FK_2E490A9BE455FCC0');
        $this->addSql('DROP INDEX IDX_2E490A9BE455FCC0');
        $this->addSql('ALTER TABLE ue DROP enseignant_id');
        $this->addSql('ALTER TABLE enseignant ALTER contact TYPE VARCHAR(255)');
    }
}
