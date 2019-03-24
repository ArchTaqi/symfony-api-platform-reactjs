<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190324091729 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE tbl_bad_words (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, word VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F82B497FC3F17511 ON tbl_bad_words (word)');
        $this->addSql('CREATE TABLE tbl_comments (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER NOT NULL, post_id INTEGER UNSIGNED NOT NULL, content VARCHAR(255) NOT NULL, published DATETIME NOT NULL)');
        $this->addSql('CREATE INDEX IDX_8AD7007F675F31B ON tbl_comments (author_id)');
        $this->addSql('CREATE INDEX IDX_8AD70074B89032C ON tbl_comments (post_id)');
        $this->addSql('CREATE TABLE tbl_posts (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL, content CLOB DEFAULT NULL, slug VARCHAR(1024) DEFAULT NULL, published BOOLEAN DEFAULT NULL, date_created DATETIME DEFAULT NULL, date_updated DATETIME DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_2639F0E5F675F31B ON tbl_posts (author_id)');
        $this->addSql('CREATE TABLE tbl_users (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, name VARCHAR(128) NOT NULL, birthday DATE NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BAE7EFF6E7927C74 ON tbl_users (email)');
        $this->addSql('CREATE TABLE tbl_likes (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, post_id INTEGER UNSIGNED NOT NULL, deleted BOOLEAN NOT NULL, date_created DATETIME DEFAULT NULL, date_updated DATETIME DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_E7AE0462A76ED395 ON tbl_likes (user_id)');
        $this->addSql('CREATE INDEX IDX_E7AE04624B89032C ON tbl_likes (post_id)');
        $this->addSql('CREATE TABLE tbl_api_settings (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, show_birthday VARCHAR(255) NOT NULL, date_created DATETIME DEFAULT NULL, date_updated DATETIME DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_C82D10DCA76ED395 ON tbl_api_settings (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE tbl_bad_words');
        $this->addSql('DROP TABLE tbl_comments');
        $this->addSql('DROP TABLE tbl_posts');
        $this->addSql('DROP TABLE tbl_users');
        $this->addSql('DROP TABLE tbl_likes');
        $this->addSql('DROP TABLE tbl_api_settings');
    }
}
