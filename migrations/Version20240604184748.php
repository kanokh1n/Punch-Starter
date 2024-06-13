<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240604184748 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pledges DROP CONSTRAINT FK_77BA3ADC6C1197C9');
        $this->addSql('ALTER TABLE pledges ADD CONSTRAINT FK_77BA3ADC6C1197C9 FOREIGN KEY (project_id_id) REFERENCES projects (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE pledges DROP CONSTRAINT fk_77ba3adc6c1197c9');
        $this->addSql('ALTER TABLE pledges ADD CONSTRAINT fk_77ba3adc6c1197c9 FOREIGN KEY (project_id_id) REFERENCES projects (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
