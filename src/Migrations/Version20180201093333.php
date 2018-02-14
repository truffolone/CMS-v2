<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180201093333 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE ext_translations (id INT AUTO_INCREMENT NOT NULL, locale VARCHAR(8) NOT NULL, object_class VARCHAR(255) NOT NULL, field VARCHAR(32) NOT NULL, foreign_key VARCHAR(64) NOT NULL, content LONGTEXT DEFAULT NULL, INDEX translations_lookup_idx (locale, object_class, foreign_key), UNIQUE INDEX lookup_unique_idx (locale, object_class, field, foreign_key), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ext_log_entries (id INT AUTO_INCREMENT NOT NULL, action VARCHAR(8) NOT NULL, logged_at DATETIME NOT NULL, object_id VARCHAR(64) DEFAULT NULL, object_class VARCHAR(255) NOT NULL, version INT NOT NULL, data LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', username VARCHAR(255) DEFAULT NULL, INDEX log_class_lookup_idx (object_class), INDEX log_date_lookup_idx (logged_at), INDEX log_user_lookup_idx (username), INDEX log_version_lookup_idx (object_id, object_class, version), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE UserInfo (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(150) NOT NULL, surname VARCHAR(150) NOT NULL, companyName VARCHAR(255) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, moreInfo LONGTEXT DEFAULT NULL, telephone VARCHAR(32) DEFAULT NULL, cellphone VARCHAR(32) DEFAULT NULL, fax VARCHAR(32) DEFAULT NULL, UNIQUE INDEX UNIQ_34B0844EA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE UserInfo ADD CONSTRAINT FK_34B0844EA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE user_info');
        $this->addSql('DROP INDEX UNIQ_1483A5E939E6FA16 ON users');
        $this->addSql('ALTER TABLE users ADD createdAt DATETIME NOT NULL, ADD updatedAt DATETIME NOT NULL, DROP created_at, DROP updated_at, CHANGE old_id oldId VARCHAR(50) DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9880A6DCB ON users (oldId)');
        $this->addSql('ALTER TABLE gruppi ADD sutterAcademy TINYINT(1) DEFAULT \'0\' NOT NULL, ADD editSutter TINYINT(1) DEFAULT \'0\' NOT NULL, ADD createdAt DATETIME NOT NULL, ADD updatedAt DATETIME NOT NULL, DROP sutter_academy, DROP edit_sutter, DROP created_at, DROP updated_at');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user_info (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(150) NOT NULL COLLATE utf8_unicode_ci, surname VARCHAR(150) NOT NULL COLLATE utf8_unicode_ci, company_name VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, address VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, more_info LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, telephone VARCHAR(32) DEFAULT NULL COLLATE utf8_unicode_ci, cellphone VARCHAR(32) DEFAULT NULL COLLATE utf8_unicode_ci, fax VARCHAR(32) DEFAULT NULL COLLATE utf8_unicode_ci, UNIQUE INDEX UNIQ_B1087D9EA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_info ADD CONSTRAINT FK_B1087D9EA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE ext_translations');
        $this->addSql('DROP TABLE ext_log_entries');
        $this->addSql('DROP TABLE UserInfo');
        $this->addSql('ALTER TABLE gruppi ADD sutter_academy TINYINT(1) DEFAULT \'0\' NOT NULL, ADD edit_sutter TINYINT(1) DEFAULT \'0\' NOT NULL, ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME NOT NULL, DROP sutterAcademy, DROP editSutter, DROP createdAt, DROP updatedAt');
        $this->addSql('DROP INDEX UNIQ_1483A5E9880A6DCB ON users');
        $this->addSql('ALTER TABLE users ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME NOT NULL, DROP createdAt, DROP updatedAt, CHANGE oldid old_id VARCHAR(50) DEFAULT NULL COLLATE utf8_unicode_ci');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E939E6FA16 ON users (old_id)');
    }
}
