<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240530114623 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE messages ADD sender_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE messages ADD absorber_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE messages ADD CONSTRAINT FK_DB021E966061F7CF FOREIGN KEY (sender_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE messages ADD CONSTRAINT FK_DB021E9619550945 FOREIGN KEY (absorber_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_DB021E966061F7CF ON messages (sender_id_id)');
        $this->addSql('CREATE INDEX IDX_DB021E9619550945 ON messages (absorber_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE messages DROP CONSTRAINT FK_DB021E966061F7CF');
        $this->addSql('ALTER TABLE messages DROP CONSTRAINT FK_DB021E9619550945');
        $this->addSql('DROP INDEX IDX_DB021E966061F7CF');
        $this->addSql('DROP INDEX IDX_DB021E9619550945');
        $this->addSql('ALTER TABLE messages DROP sender_id_id');
        $this->addSql('ALTER TABLE messages DROP absorber_id_id');
    }
}
