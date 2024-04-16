<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240416130136 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE projects DROP CONSTRAINT fk_5c93b3a42f23775f');
        $this->addSql('DROP SEQUENCE likes_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE messages_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE messages (id INT NOT NULL, title VARCHAR(255) NOT NULL, content VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, status INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN messages.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE likes DROP CONSTRAINT fk_49ca4e7d9d86650f');
        $this->addSql('DROP TABLE likes');
        $this->addSql('DROP INDEX idx_5c93b3a42f23775f');
        $this->addSql('ALTER TABLE projects DROP likes_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE messages_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE likes_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE likes (id INT NOT NULL, user_id_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_49ca4e7d9d86650f ON likes (user_id_id)');
        $this->addSql('ALTER TABLE likes ADD CONSTRAINT fk_49ca4e7d9d86650f FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE messages');
        $this->addSql('ALTER TABLE projects ADD likes_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE projects ADD CONSTRAINT fk_5c93b3a42f23775f FOREIGN KEY (likes_id) REFERENCES likes (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_5c93b3a42f23775f ON projects (likes_id)');
    }
}
