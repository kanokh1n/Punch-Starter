<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240327093257 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE categories_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE comments_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE pledges_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE project_info_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE projects_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE projects_categories_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE roles_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE statuses_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE user_profile_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE users_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE users_roles_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE categories (id INT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE comments (id INT NOT NULL, user_id_id INT NOT NULL, projects_id_id INT NOT NULL, content VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5F9E962A9D86650F ON comments (user_id_id)');
        $this->addSql('CREATE INDEX IDX_5F9E962AEAC5CA69 ON comments (projects_id_id)');
        $this->addSql('COMMENT ON COLUMN comments.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE pledges (id INT NOT NULL, user_id_id INT NOT NULL, project_id_id INT NOT NULL, amount NUMERIC(10, 2) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_77BA3ADC9D86650F ON pledges (user_id_id)');
        $this->addSql('CREATE INDEX IDX_77BA3ADC6C1197C9 ON pledges (project_id_id)');
        $this->addSql('COMMENT ON COLUMN pledges.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE project_info (id INT NOT NULL, project_id_id INT NOT NULL, title VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, current_amount NUMERIC(10, 2) NOT NULL, goal_amount NUMERIC(10, 2) NOT NULL, project_img VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F218F94F6C1197C9 ON project_info (project_id_id)');
        $this->addSql('COMMENT ON COLUMN project_info.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN project_info.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE projects (id INT NOT NULL, user_id_id INT NOT NULL, status_id_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5C93B3A49D86650F ON projects (user_id_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5C93B3A4881ECFA7 ON projects (status_id_id)');
        $this->addSql('CREATE TABLE projects_categories (id INT NOT NULL, project_id_id INT NOT NULL, categories_id_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8C4CD7926C1197C9 ON projects_categories (project_id_id)');
        $this->addSql('CREATE INDEX IDX_8C4CD7927B478B1A ON projects_categories (categories_id_id)');
        $this->addSql('CREATE TABLE roles (id INT NOT NULL, eшtitle VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE statuses (id INT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE user_profile (id INT NOT NULL, user_id_id INT NOT NULL, fio VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, profile_img VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D95AB4059D86650F ON user_profile (user_id_id)');
        $this->addSql('CREATE TABLE users (id INT NOT NULL, login VARCHAR(255) NOT NULL, password_hash VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN users.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE users_roles (id INT NOT NULL, user_id_id INT NOT NULL, role_id_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_51498A8E9D86650F ON users_roles (user_id_id)');
        $this->addSql('CREATE INDEX IDX_51498A8E88987678 ON users_roles (role_id_id)');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962A9D86650F FOREIGN KEY (user_id_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962AEAC5CA69 FOREIGN KEY (projects_id_id) REFERENCES projects (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE pledges ADD CONSTRAINT FK_77BA3ADC9D86650F FOREIGN KEY (user_id_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE pledges ADD CONSTRAINT FK_77BA3ADC6C1197C9 FOREIGN KEY (project_id_id) REFERENCES projects (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE project_info ADD CONSTRAINT FK_F218F94F6C1197C9 FOREIGN KEY (project_id_id) REFERENCES projects (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE projects ADD CONSTRAINT FK_5C93B3A49D86650F FOREIGN KEY (user_id_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE projects ADD CONSTRAINT FK_5C93B3A4881ECFA7 FOREIGN KEY (status_id_id) REFERENCES statuses (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE projects_categories ADD CONSTRAINT FK_8C4CD7926C1197C9 FOREIGN KEY (project_id_id) REFERENCES projects (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE projects_categories ADD CONSTRAINT FK_8C4CD7927B478B1A FOREIGN KEY (categories_id_id) REFERENCES categories (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_profile ADD CONSTRAINT FK_D95AB4059D86650F FOREIGN KEY (user_id_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE users_roles ADD CONSTRAINT FK_51498A8E9D86650F FOREIGN KEY (user_id_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE users_roles ADD CONSTRAINT FK_51498A8E88987678 FOREIGN KEY (role_id_id) REFERENCES roles (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE categories_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE comments_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE pledges_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE project_info_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE projects_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE projects_categories_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE roles_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE statuses_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE user_profile_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE users_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE users_roles_id_seq CASCADE');
        $this->addSql('ALTER TABLE comments DROP CONSTRAINT FK_5F9E962A9D86650F');
        $this->addSql('ALTER TABLE comments DROP CONSTRAINT FK_5F9E962AEAC5CA69');
        $this->addSql('ALTER TABLE pledges DROP CONSTRAINT FK_77BA3ADC9D86650F');
        $this->addSql('ALTER TABLE pledges DROP CONSTRAINT FK_77BA3ADC6C1197C9');
        $this->addSql('ALTER TABLE project_info DROP CONSTRAINT FK_F218F94F6C1197C9');
        $this->addSql('ALTER TABLE projects DROP CONSTRAINT FK_5C93B3A49D86650F');
        $this->addSql('ALTER TABLE projects DROP CONSTRAINT FK_5C93B3A4881ECFA7');
        $this->addSql('ALTER TABLE projects_categories DROP CONSTRAINT FK_8C4CD7926C1197C9');
        $this->addSql('ALTER TABLE projects_categories DROP CONSTRAINT FK_8C4CD7927B478B1A');
        $this->addSql('ALTER TABLE user_profile DROP CONSTRAINT FK_D95AB4059D86650F');
        $this->addSql('ALTER TABLE users_roles DROP CONSTRAINT FK_51498A8E9D86650F');
        $this->addSql('ALTER TABLE users_roles DROP CONSTRAINT FK_51498A8E88987678');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE comments');
        $this->addSql('DROP TABLE pledges');
        $this->addSql('DROP TABLE project_info');
        $this->addSql('DROP TABLE projects');
        $this->addSql('DROP TABLE projects_categories');
        $this->addSql('DROP TABLE roles');
        $this->addSql('DROP TABLE statuses');
        $this->addSql('DROP TABLE user_profile');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE users_roles');
    }
}
