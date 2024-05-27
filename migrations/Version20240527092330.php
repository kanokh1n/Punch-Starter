<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240527092330 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE likes_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE likes (id INT NOT NULL, project_id_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_49CA4E7D6C1197C9 ON likes (project_id_id)');
        $this->addSql('CREATE TABLE likes_user (likes_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(likes_id, user_id))');
        $this->addSql('CREATE INDEX IDX_17BC4AF82F23775F ON likes_user (likes_id)');
        $this->addSql('CREATE INDEX IDX_17BC4AF8A76ED395 ON likes_user (user_id)');
        $this->addSql('ALTER TABLE likes ADD CONSTRAINT FK_49CA4E7D6C1197C9 FOREIGN KEY (project_id_id) REFERENCES projects (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE likes_user ADD CONSTRAINT FK_17BC4AF82F23775F FOREIGN KEY (likes_id) REFERENCES likes (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE likes_user ADD CONSTRAINT FK_17BC4AF8A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE comments ALTER content TYPE VARCHAR(1500)');
        $this->addSql('ALTER TABLE project_info ALTER description TYPE VARCHAR(1500)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE likes_id_seq CASCADE');
        $this->addSql('ALTER TABLE likes DROP CONSTRAINT FK_49CA4E7D6C1197C9');
        $this->addSql('ALTER TABLE likes_user DROP CONSTRAINT FK_17BC4AF82F23775F');
        $this->addSql('ALTER TABLE likes_user DROP CONSTRAINT FK_17BC4AF8A76ED395');
        $this->addSql('DROP TABLE likes');
        $this->addSql('DROP TABLE likes_user');
        $this->addSql('ALTER TABLE comments ALTER content TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE project_info ALTER description TYPE VARCHAR(255)');
    }
}
