<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250918015310 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE chapitre (id SERIAL NOT NULL, ue_id INT NOT NULL, titre VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8C62B02562E883B1 ON chapitre (ue_id)');
        $this->addSql('CREATE TABLE enseignant (id SERIAL NOT NULL, nom VARCHAR(255) NOT NULL, prenoms VARCHAR(255) NOT NULL, matricule INT NOT NULL, grade VARCHAR(255) NOT NULL, mail VARCHAR(255) NOT NULL, contact VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE proposition (id SERIAL NOT NULL, question_id INT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C7CDC3531E27F6BF ON proposition (question_id)');
        $this->addSql('CREATE TABLE question (id SERIAL NOT NULL, chapitre_id INT NOT NULL, intitule VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, etat_validation VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B6F7494E1FBEEF7B ON question (chapitre_id)');
        $this->addSql('CREATE TABLE sujet (id SERIAL NOT NULL, enseignant_id INT NOT NULL, niveau_difficulte VARCHAR(255) NOT NULL, duree INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2E13599DE455FCC0 ON sujet (enseignant_id)');
        $this->addSql('CREATE TABLE sujet_question (sujet_id INT NOT NULL, question_id INT NOT NULL, PRIMARY KEY(sujet_id, question_id))');
        $this->addSql('CREATE INDEX IDX_8214A3BF7C4D497E ON sujet_question (sujet_id)');
        $this->addSql('CREATE INDEX IDX_8214A3BF1E27F6BF ON sujet_question (question_id)');
        $this->addSql('CREATE TABLE ue (id SERIAL NOT NULL, code VARCHAR(255) NOT NULL, nbre_credits INT NOT NULL, semestre INT NOT NULL, annee INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('COMMENT ON COLUMN messenger_messages.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.available_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.delivered_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE chapitre ADD CONSTRAINT FK_8C62B02562E883B1 FOREIGN KEY (ue_id) REFERENCES ue (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE proposition ADD CONSTRAINT FK_C7CDC3531E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494E1FBEEF7B FOREIGN KEY (chapitre_id) REFERENCES chapitre (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE sujet ADD CONSTRAINT FK_2E13599DE455FCC0 FOREIGN KEY (enseignant_id) REFERENCES enseignant (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE sujet_question ADD CONSTRAINT FK_8214A3BF7C4D497E FOREIGN KEY (sujet_id) REFERENCES sujet (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE sujet_question ADD CONSTRAINT FK_8214A3BF1E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE chapitre DROP CONSTRAINT FK_8C62B02562E883B1');
        $this->addSql('ALTER TABLE proposition DROP CONSTRAINT FK_C7CDC3531E27F6BF');
        $this->addSql('ALTER TABLE question DROP CONSTRAINT FK_B6F7494E1FBEEF7B');
        $this->addSql('ALTER TABLE sujet DROP CONSTRAINT FK_2E13599DE455FCC0');
        $this->addSql('ALTER TABLE sujet_question DROP CONSTRAINT FK_8214A3BF7C4D497E');
        $this->addSql('ALTER TABLE sujet_question DROP CONSTRAINT FK_8214A3BF1E27F6BF');
        $this->addSql('DROP TABLE chapitre');
        $this->addSql('DROP TABLE enseignant');
        $this->addSql('DROP TABLE proposition');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE sujet');
        $this->addSql('DROP TABLE sujet_question');
        $this->addSql('DROP TABLE ue');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
