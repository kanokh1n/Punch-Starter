<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240530115128 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE users_messages_id_seq CASCADE');
        $this->addSql('ALTER TABLE users_messages DROP CONSTRAINT fk_a043354c537a1329');
        $this->addSql('ALTER TABLE users_messages DROP CONSTRAINT fk_a043354cf6c43e79');
        $this->addSql('ALTER TABLE users_messages DROP CONSTRAINT fk_a043354c69e3f37a');
        $this->addSql('DROP TABLE users_messages');
        $this->addSql('ALTER TABLE messages DROP created_at');
        $this->addSql('ALTER TABLE messages DROP status');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE users_messages_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE users_messages (id INT NOT NULL, message_id INT NOT NULL, user_sender_id INT NOT NULL, user_recipient_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_a043354c69e3f37a ON users_messages (user_recipient_id)');
        $this->addSql('CREATE INDEX idx_a043354cf6c43e79 ON users_messages (user_sender_id)');
        $this->addSql('CREATE UNIQUE INDEX uniq_a043354c537a1329 ON users_messages (message_id)');
        $this->addSql('ALTER TABLE users_messages ADD CONSTRAINT fk_a043354c537a1329 FOREIGN KEY (message_id) REFERENCES messages (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE users_messages ADD CONSTRAINT fk_a043354cf6c43e79 FOREIGN KEY (user_sender_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE users_messages ADD CONSTRAINT fk_a043354c69e3f37a FOREIGN KEY (user_recipient_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE messages ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE messages ADD status INT NOT NULL');
        $this->addSql('COMMENT ON COLUMN messages.created_at IS \'(DC2Type:datetime_immutable)\'');
    }
}
