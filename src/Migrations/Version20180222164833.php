<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180222164833 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX domain ON domains');
        $this->addSql('ALTER TABLE domains CHANGE domain domain VARCHAR(255) NOT NULL UNIQUE');
        $this->addSql('DROP INDEX email ON clients');
        $this->addSql('ALTER TABLE clients CHANGE email email VARCHAR(255) NOT NULL UNIQUE');
        $this->addSql('DROP INDEX name ON roles');
        $this->addSql('DROP INDEX slug ON roles');
        $this->addSql('ALTER TABLE roles CHANGE name name VARCHAR(255) NOT NULL UNIQUE, CHANGE slug slug VARCHAR(64) NOT NULL UNIQUE');
        $this->addSql('ALTER TABLE contracts ADD domain_id INT NOT NULL');
        $this->addSql('ALTER TABLE contracts ADD CONSTRAINT FK_950A973115F0EE5 FOREIGN KEY (domain_id) REFERENCES domains (id)');
        $this->addSql('CREATE INDEX IDX_950A973115F0EE5 ON contracts (domain_id)');
        $this->addSql('ALTER TABLE sessions CHANGE sess_id sess_id VARCHAR(128) NOT NULL');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE clients CHANGE email email VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('CREATE UNIQUE INDEX email ON clients (email)');
        $this->addSql('ALTER TABLE contracts DROP FOREIGN KEY FK_950A973115F0EE5');
        $this->addSql('DROP INDEX IDX_950A973115F0EE5 ON contracts');
        $this->addSql('ALTER TABLE contracts DROP domain_id');
        $this->addSql('ALTER TABLE domains CHANGE domain domain VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('CREATE UNIQUE INDEX domain ON domains (domain)');
        $this->addSql('ALTER TABLE roles CHANGE name name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE slug slug VARCHAR(64) NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('CREATE UNIQUE INDEX name ON roles (name)');
        $this->addSql('CREATE UNIQUE INDEX slug ON roles (slug)');
        $this->addSql('ALTER TABLE sessions CHANGE sess_id sess_id VARCHAR(128) NOT NULL COLLATE utf8_bin');
    }
}
