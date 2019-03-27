<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190327113554 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_2639F0E5F675F31B');
        $this->addSql('CREATE TEMPORARY TABLE __temp__tbl_posts AS SELECT id, author_id, title, content, slug, published, date_created, date_updated FROM tbl_posts');
        $this->addSql('DROP TABLE tbl_posts');
        $this->addSql('CREATE TABLE tbl_posts (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL COLLATE BINARY, content CLOB DEFAULT NULL COLLATE BINARY, slug VARCHAR(1024) DEFAULT NULL COLLATE BINARY, published BOOLEAN DEFAULT NULL, date_created DATETIME DEFAULT NULL, date_updated DATETIME DEFAULT NULL, CONSTRAINT FK_2639F0E5F675F31B FOREIGN KEY (author_id) REFERENCES tbl_users (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO tbl_posts (id, author_id, title, content, slug, published, date_created, date_updated) SELECT id, author_id, title, content, slug, published, date_created, date_updated FROM __temp__tbl_posts');
        $this->addSql('DROP TABLE __temp__tbl_posts');
        $this->addSql('CREATE INDEX IDX_2639F0E5F675F31B ON tbl_posts (author_id)');
        $this->addSql('DROP INDEX IDX_8AD70074B89032C');
        $this->addSql('DROP INDEX IDX_8AD7007F675F31B');
        $this->addSql('CREATE TEMPORARY TABLE __temp__tbl_comments AS SELECT id, author_id, post_id, content, published FROM tbl_comments');
        $this->addSql('DROP TABLE tbl_comments');
        $this->addSql('CREATE TABLE tbl_comments (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER NOT NULL, post_id INTEGER UNSIGNED NOT NULL, content VARCHAR(255) NOT NULL COLLATE BINARY, published DATETIME NOT NULL, CONSTRAINT FK_8AD7007F675F31B FOREIGN KEY (author_id) REFERENCES tbl_users (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_8AD70074B89032C FOREIGN KEY (post_id) REFERENCES tbl_posts (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO tbl_comments (id, author_id, post_id, content, published) SELECT id, author_id, post_id, content, published FROM __temp__tbl_comments');
        $this->addSql('DROP TABLE __temp__tbl_comments');
        $this->addSql('CREATE INDEX IDX_8AD70074B89032C ON tbl_comments (post_id)');
        $this->addSql('CREATE INDEX IDX_8AD7007F675F31B ON tbl_comments (author_id)');
        $this->addSql('DROP INDEX UNIQ_BAE7EFF6E7927C74');
        $this->addSql('CREATE TEMPORARY TABLE __temp__tbl_users AS SELECT id, email, name, birthday, roles, password FROM tbl_users');
        $this->addSql('DROP TABLE tbl_users');
        $this->addSql('CREATE TABLE tbl_users (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL COLLATE BINARY, name VARCHAR(128) NOT NULL COLLATE BINARY, birthday DATE NOT NULL, roles CLOB NOT NULL COLLATE BINARY --(DC2Type:json)
        , password VARCHAR(255) NOT NULL COLLATE BINARY, username VARCHAR(180) NOT NULL)');
        $this->addSql('INSERT INTO tbl_users (id, email, name, birthday, roles, password) SELECT id, email, name, birthday, roles, password FROM __temp__tbl_users');
        $this->addSql('DROP TABLE __temp__tbl_users');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BAE7EFF6E7927C74 ON tbl_users (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BAE7EFF6F85E0677 ON tbl_users (username)');
        $this->addSql('DROP INDEX IDX_E7AE04624B89032C');
        $this->addSql('DROP INDEX IDX_E7AE0462A76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__tbl_likes AS SELECT id, user_id, post_id, deleted, date_created, date_updated FROM tbl_likes');
        $this->addSql('DROP TABLE tbl_likes');
        $this->addSql('CREATE TABLE tbl_likes (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, post_id INTEGER UNSIGNED NOT NULL, deleted BOOLEAN NOT NULL, date_created DATETIME DEFAULT NULL, date_updated DATETIME DEFAULT NULL, CONSTRAINT FK_E7AE0462A76ED395 FOREIGN KEY (user_id) REFERENCES tbl_users (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_E7AE04624B89032C FOREIGN KEY (post_id) REFERENCES tbl_posts (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO tbl_likes (id, user_id, post_id, deleted, date_created, date_updated) SELECT id, user_id, post_id, deleted, date_created, date_updated FROM __temp__tbl_likes');
        $this->addSql('DROP TABLE __temp__tbl_likes');
        $this->addSql('CREATE INDEX IDX_E7AE04624B89032C ON tbl_likes (post_id)');
        $this->addSql('CREATE INDEX IDX_E7AE0462A76ED395 ON tbl_likes (user_id)');
        $this->addSql('DROP INDEX IDX_C82D10DCA76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__tbl_api_settings AS SELECT id, user_id, show_birthday, date_created, date_updated FROM tbl_api_settings');
        $this->addSql('DROP TABLE tbl_api_settings');
        $this->addSql('CREATE TABLE tbl_api_settings (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, show_birthday VARCHAR(255) NOT NULL COLLATE BINARY, date_created DATETIME DEFAULT NULL, date_updated DATETIME DEFAULT NULL, CONSTRAINT FK_C82D10DCA76ED395 FOREIGN KEY (user_id) REFERENCES tbl_users (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO tbl_api_settings (id, user_id, show_birthday, date_created, date_updated) SELECT id, user_id, show_birthday, date_created, date_updated FROM __temp__tbl_api_settings');
        $this->addSql('DROP TABLE __temp__tbl_api_settings');
        $this->addSql('CREATE INDEX IDX_C82D10DCA76ED395 ON tbl_api_settings (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_C82D10DCA76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__tbl_api_settings AS SELECT id, user_id, show_birthday, date_created, date_updated FROM tbl_api_settings');
        $this->addSql('DROP TABLE tbl_api_settings');
        $this->addSql('CREATE TABLE tbl_api_settings (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, show_birthday VARCHAR(255) NOT NULL, date_created DATETIME DEFAULT NULL, date_updated DATETIME DEFAULT NULL)');
        $this->addSql('INSERT INTO tbl_api_settings (id, user_id, show_birthday, date_created, date_updated) SELECT id, user_id, show_birthday, date_created, date_updated FROM __temp__tbl_api_settings');
        $this->addSql('DROP TABLE __temp__tbl_api_settings');
        $this->addSql('CREATE INDEX IDX_C82D10DCA76ED395 ON tbl_api_settings (user_id)');
        $this->addSql('DROP INDEX IDX_8AD7007F675F31B');
        $this->addSql('DROP INDEX IDX_8AD70074B89032C');
        $this->addSql('CREATE TEMPORARY TABLE __temp__tbl_comments AS SELECT id, author_id, post_id, content, published FROM tbl_comments');
        $this->addSql('DROP TABLE tbl_comments');
        $this->addSql('CREATE TABLE tbl_comments (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER NOT NULL, post_id INTEGER UNSIGNED NOT NULL, content VARCHAR(255) NOT NULL, published DATETIME NOT NULL)');
        $this->addSql('INSERT INTO tbl_comments (id, author_id, post_id, content, published) SELECT id, author_id, post_id, content, published FROM __temp__tbl_comments');
        $this->addSql('DROP TABLE __temp__tbl_comments');
        $this->addSql('CREATE INDEX IDX_8AD7007F675F31B ON tbl_comments (author_id)');
        $this->addSql('CREATE INDEX IDX_8AD70074B89032C ON tbl_comments (post_id)');
        $this->addSql('DROP INDEX IDX_E7AE0462A76ED395');
        $this->addSql('DROP INDEX IDX_E7AE04624B89032C');
        $this->addSql('CREATE TEMPORARY TABLE __temp__tbl_likes AS SELECT id, user_id, post_id, deleted, date_created, date_updated FROM tbl_likes');
        $this->addSql('DROP TABLE tbl_likes');
        $this->addSql('CREATE TABLE tbl_likes (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, post_id INTEGER UNSIGNED NOT NULL, deleted BOOLEAN NOT NULL, date_created DATETIME DEFAULT NULL, date_updated DATETIME DEFAULT NULL)');
        $this->addSql('INSERT INTO tbl_likes (id, user_id, post_id, deleted, date_created, date_updated) SELECT id, user_id, post_id, deleted, date_created, date_updated FROM __temp__tbl_likes');
        $this->addSql('DROP TABLE __temp__tbl_likes');
        $this->addSql('CREATE INDEX IDX_E7AE0462A76ED395 ON tbl_likes (user_id)');
        $this->addSql('CREATE INDEX IDX_E7AE04624B89032C ON tbl_likes (post_id)');
        $this->addSql('DROP INDEX IDX_2639F0E5F675F31B');
        $this->addSql('CREATE TEMPORARY TABLE __temp__tbl_posts AS SELECT id, author_id, title, content, slug, published, date_created, date_updated FROM tbl_posts');
        $this->addSql('DROP TABLE tbl_posts');
        $this->addSql('CREATE TABLE tbl_posts (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL, content CLOB DEFAULT NULL, slug VARCHAR(1024) DEFAULT NULL, published BOOLEAN DEFAULT NULL, date_created DATETIME DEFAULT NULL, date_updated DATETIME DEFAULT NULL)');
        $this->addSql('INSERT INTO tbl_posts (id, author_id, title, content, slug, published, date_created, date_updated) SELECT id, author_id, title, content, slug, published, date_created, date_updated FROM __temp__tbl_posts');
        $this->addSql('DROP TABLE __temp__tbl_posts');
        $this->addSql('CREATE INDEX IDX_2639F0E5F675F31B ON tbl_posts (author_id)');
        $this->addSql('DROP INDEX UNIQ_BAE7EFF6F85E0677');
        $this->addSql('DROP INDEX UNIQ_BAE7EFF6E7927C74');
        $this->addSql('CREATE TEMPORARY TABLE __temp__tbl_users AS SELECT id, email, name, birthday, roles, password FROM tbl_users');
        $this->addSql('DROP TABLE tbl_users');
        $this->addSql('CREATE TABLE tbl_users (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, name VARCHAR(128) NOT NULL, birthday DATE NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO tbl_users (id, email, name, birthday, roles, password) SELECT id, email, name, birthday, roles, password FROM __temp__tbl_users');
        $this->addSql('DROP TABLE __temp__tbl_users');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BAE7EFF6E7927C74 ON tbl_users (email)');
    }
}
