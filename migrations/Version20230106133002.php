<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230106133002 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__article AS SELECT id, title, slug, content, published_at, author, heart_count, image_filename FROM article');
        $this->addSql('DROP TABLE article');
        $this->addSql('CREATE TABLE article (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(100) NOT NULL, content CLOB DEFAULT NULL, published_at DATETIME DEFAULT NULL, author VARCHAR(255) NOT NULL, heart_count INTEGER NOT NULL, image_filename VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO article (id, title, slug, content, published_at, author, heart_count, image_filename) SELECT id, title, slug, content, published_at, author, heart_count, image_filename FROM __temp__article');
        $this->addSql('DROP TABLE __temp__article');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_23A0E66989D9B62 ON article (slug)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__article AS SELECT id, title, slug, content, published_at, author, heart_count, image_filename FROM article');
        $this->addSql('DROP TABLE article');
        $this->addSql('CREATE TABLE article (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(100) NOT NULL, content CLOB DEFAULT NULL, published_at DATETIME DEFAULT NULL, author VARCHAR(255) DEFAULT NULL, heart_count INTEGER DEFAULT NULL, image_filename VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO article (id, title, slug, content, published_at, author, heart_count, image_filename) SELECT id, title, slug, content, published_at, author, heart_count, image_filename FROM __temp__article');
        $this->addSql('DROP TABLE __temp__article');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_23A0E66989D9B62 ON article (slug)');
    }
}
