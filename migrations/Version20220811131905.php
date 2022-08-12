<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220811131905 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE url_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE telegram_user (id INT NOT NULL, first_name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, username VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE url (id INT NOT NULL, user_id_id INT NOT NULL, url VARCHAR(255) NOT NULL, name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F47645AE9D86650F ON url (user_id_id)');
        $this->addSql('ALTER TABLE url ADD CONSTRAINT FK_F47645AE9D86650F FOREIGN KEY (user_id_id) REFERENCES telegram_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE url DROP CONSTRAINT FK_F47645AE9D86650F');
        $this->addSql('DROP SEQUENCE url_id_seq CASCADE');
        $this->addSql('DROP TABLE telegram_user');
        $this->addSql('DROP TABLE url');
    }
}
