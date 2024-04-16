<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240416131205 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE users_messages_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE users_messages (id INT NOT NULL, message_id INT NOT NULL, user_sender_id INT NOT NULL, user_recipient_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A043354C537A1329 ON users_messages (message_id)');
        $this->addSql('CREATE INDEX IDX_A043354CF6C43E79 ON users_messages (user_sender_id)');
        $this->addSql('CREATE INDEX IDX_A043354C69E3F37A ON users_messages (user_recipient_id)');
        $this->addSql('ALTER TABLE users_messages ADD CONSTRAINT FK_A043354C537A1329 FOREIGN KEY (message_id) REFERENCES messages (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE users_messages ADD CONSTRAINT FK_A043354CF6C43E79 FOREIGN KEY (user_sender_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE users_messages ADD CONSTRAINT FK_A043354C69E3F37A FOREIGN KEY (user_recipient_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE users_messages_id_seq CASCADE');
        $this->addSql('ALTER TABLE users_messages DROP CONSTRAINT FK_A043354C537A1329');
        $this->addSql('ALTER TABLE users_messages DROP CONSTRAINT FK_A043354CF6C43E79');
        $this->addSql('ALTER TABLE users_messages DROP CONSTRAINT FK_A043354C69E3F37A');
        $this->addSql('DROP TABLE users_messages');
    }
}
