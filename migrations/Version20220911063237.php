<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220911063237 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article_article_tags (article_id INT NOT NULL, article_tags_id INT NOT NULL, PRIMARY KEY(article_id, article_tags_id))');
        $this->addSql('CREATE INDEX IDX_CB264B67294869C ON article_article_tags (article_id)');
        $this->addSql('CREATE INDEX IDX_CB264B660A90B03 ON article_article_tags (article_tags_id)');
        $this->addSql('ALTER TABLE article_article_tags ADD CONSTRAINT FK_CB264B67294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE article_article_tags ADD CONSTRAINT FK_CB264B660A90B03 FOREIGN KEY (article_tags_id) REFERENCES article_tags (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE article_article_tags');
    }
}
