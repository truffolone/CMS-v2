<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180206150229 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user_info (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(150) NOT NULL, surname VARCHAR(150) NOT NULL, companyName VARCHAR(255) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, moreInfo LONGTEXT DEFAULT NULL, telephone VARCHAR(32) DEFAULT NULL, cellphone VARCHAR(32) DEFAULT NULL, fax VARCHAR(32) DEFAULT NULL, UNIQUE INDEX UNIQ_B1087D9EA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_info ADD CONSTRAINT FK_B1087D9EA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE UserInfo');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE UserInfo (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(150) NOT NULL COLLATE utf8_unicode_ci, surname VARCHAR(150) NOT NULL COLLATE utf8_unicode_ci, companyName VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, address VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, moreInfo LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, telephone VARCHAR(32) DEFAULT NULL COLLATE utf8_unicode_ci, cellphone VARCHAR(32) DEFAULT NULL COLLATE utf8_unicode_ci, fax VARCHAR(32) DEFAULT NULL COLLATE utf8_unicode_ci, UNIQUE INDEX UNIQ_34B0844EA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE UserInfo ADD CONSTRAINT FK_34B0844EA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE user_info');
    }
}
