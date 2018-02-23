<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180223090718 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE users_contracts (user_id INT NOT NULL, contract_id INT NOT NULL, INDEX IDX_6F2DD392A76ED395 (user_id), INDEX IDX_6F2DD3922576E0FD (contract_id), PRIMARY KEY(user_id, contract_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE users_contracts ADD CONSTRAINT FK_6F2DD392A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_contracts ADD CONSTRAINT FK_6F2DD3922576E0FD FOREIGN KEY (contract_id) REFERENCES contracts (id) ON DELETE CASCADE');
        $this->addSql('DROP INDEX name ON roles');
        $this->addSql('DROP INDEX slug ON roles');
        $this->addSql('ALTER TABLE roles CHANGE name name VARCHAR(255) NOT NULL UNIQUE, CHANGE slug slug VARCHAR(64) NOT NULL UNIQUE');
        $this->addSql('DROP INDEX domain ON domains');
        $this->addSql('ALTER TABLE domains CHANGE domain domain VARCHAR(255) NOT NULL UNIQUE');
        $this->addSql('DROP INDEX email ON clients');
        $this->addSql('ALTER TABLE clients CHANGE email email VARCHAR(255) NOT NULL UNIQUE');
        $this->addSql('ALTER TABLE sessions CHANGE sess_id sess_id VARCHAR(128) NOT NULL');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE users_contracts');
        $this->addSql('ALTER TABLE clients CHANGE email email VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('CREATE UNIQUE INDEX email ON clients (email)');
        $this->addSql('ALTER TABLE domains CHANGE domain domain VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('CREATE UNIQUE INDEX domain ON domains (domain)');
        $this->addSql('ALTER TABLE roles CHANGE name name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE slug slug VARCHAR(64) NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('CREATE UNIQUE INDEX name ON roles (name)');
        $this->addSql('CREATE UNIQUE INDEX slug ON roles (slug)');
        $this->addSql('ALTER TABLE sessions CHANGE sess_id sess_id VARCHAR(128) NOT NULL COLLATE utf8_bin');
    }
}
