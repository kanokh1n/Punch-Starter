<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240527093521 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE likes_user DROP CONSTRAINT fk_17bc4af82f23775f');
        $this->addSql('ALTER TABLE likes_user DROP CONSTRAINT fk_17bc4af8a76ed395');
        $this->addSql('DROP TABLE likes_user');
        $this->addSql('ALTER TABLE likes ADD user_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE likes ADD CONSTRAINT FK_49CA4E7D9D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_49CA4E7D9D86650F ON likes (user_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE likes_user (likes_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(likes_id, user_id))');
        $this->addSql('CREATE INDEX idx_17bc4af8a76ed395 ON likes_user (user_id)');
        $this->addSql('CREATE INDEX idx_17bc4af82f23775f ON likes_user (likes_id)');
        $this->addSql('ALTER TABLE likes_user ADD CONSTRAINT fk_17bc4af82f23775f FOREIGN KEY (likes_id) REFERENCES likes (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE likes_user ADD CONSTRAINT fk_17bc4af8a76ed395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE likes DROP CONSTRAINT FK_49CA4E7D9D86650F');
        $this->addSql('DROP INDEX IDX_49CA4E7D9D86650F');
        $this->addSql('ALTER TABLE likes DROP user_id_id');
    }
}
