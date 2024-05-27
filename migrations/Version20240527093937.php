<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240527093937 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE likes DROP CONSTRAINT fk_49ca4e7d6c1197c9');
        $this->addSql('ALTER TABLE likes DROP CONSTRAINT fk_49ca4e7d9d86650f');
        $this->addSql('DROP INDEX idx_49ca4e7d9d86650f');
        $this->addSql('DROP INDEX idx_49ca4e7d6c1197c9');
        $this->addSql('ALTER TABLE likes ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE likes ADD project_id INT NOT NULL');
        $this->addSql('ALTER TABLE likes DROP project_id_id');
        $this->addSql('ALTER TABLE likes DROP user_id_id');
        $this->addSql('ALTER TABLE likes ADD CONSTRAINT FK_49CA4E7DA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE likes ADD CONSTRAINT FK_49CA4E7D166D1F9C FOREIGN KEY (project_id) REFERENCES projects (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_49CA4E7DA76ED395 ON likes (user_id)');
        $this->addSql('CREATE INDEX IDX_49CA4E7D166D1F9C ON likes (project_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE likes DROP CONSTRAINT FK_49CA4E7DA76ED395');
        $this->addSql('ALTER TABLE likes DROP CONSTRAINT FK_49CA4E7D166D1F9C');
        $this->addSql('DROP INDEX IDX_49CA4E7DA76ED395');
        $this->addSql('DROP INDEX IDX_49CA4E7D166D1F9C');
        $this->addSql('ALTER TABLE likes ADD project_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE likes ADD user_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE likes DROP user_id');
        $this->addSql('ALTER TABLE likes DROP project_id');
        $this->addSql('ALTER TABLE likes ADD CONSTRAINT fk_49ca4e7d6c1197c9 FOREIGN KEY (project_id_id) REFERENCES projects (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE likes ADD CONSTRAINT fk_49ca4e7d9d86650f FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_49ca4e7d9d86650f ON likes (user_id_id)');
        $this->addSql('CREATE INDEX idx_49ca4e7d6c1197c9 ON likes (project_id_id)');
    }
}
