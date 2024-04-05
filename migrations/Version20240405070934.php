<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240405070934 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE user_profile_id_seq CASCADE');
        $this->addSql('ALTER TABLE user_profile DROP CONSTRAINT fk_d95ab4059d86650f');
        $this->addSql('DROP TABLE user_profile');
        $this->addSql('ALTER TABLE "user" ADD fio VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD description VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD profile_img VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD phone VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE user_profile_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE user_profile (id INT NOT NULL, user_id_id INT NOT NULL, fio VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, profile_img VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX uniq_d95ab4059d86650f ON user_profile (user_id_id)');
        $this->addSql('ALTER TABLE user_profile ADD CONSTRAINT fk_d95ab4059d86650f FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" DROP fio');
        $this->addSql('ALTER TABLE "user" DROP description');
        $this->addSql('ALTER TABLE "user" DROP profile_img');
        $this->addSql('ALTER TABLE "user" DROP phone');
    }
}
