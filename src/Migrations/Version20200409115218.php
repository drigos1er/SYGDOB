<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200409115218 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE sygdob_role (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sygdob_role_sygdob_user (sygdob_role_id INT NOT NULL, sygdob_user_id INT NOT NULL, INDEX IDX_F0E91BFE5303136F (sygdob_role_id), INDEX IDX_F0E91BFE226EE256 (sygdob_user_id), PRIMARY KEY(sygdob_role_id, sygdob_user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sygdob_user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(150) NOT NULL, firstname VARCHAR(150) NOT NULL, lastname VARCHAR(255) NOT NULL, gender VARCHAR(1) NOT NULL, phone VARCHAR(25) DEFAULT NULL, email VARCHAR(255) NOT NULL, picture VARCHAR(150) DEFAULT NULL, updprofil TINYINT(1) DEFAULT NULL, enabled TINYINT(1) DEFAULT NULL, last_login DATETIME DEFAULT NULL, password VARCHAR(255) NOT NULL, token VARCHAR(255) DEFAULT NULL, creatdat DATETIME NOT NULL, upddat DATETIME NOT NULL, tokendat DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sygdob_role_sygdob_user ADD CONSTRAINT FK_F0E91BFE5303136F FOREIGN KEY (sygdob_role_id) REFERENCES sygdob_role (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sygdob_role_sygdob_user ADD CONSTRAINT FK_F0E91BFE226EE256 FOREIGN KEY (sygdob_user_id) REFERENCES sygdob_user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sygdob_role_sygdob_user DROP FOREIGN KEY FK_F0E91BFE5303136F');
        $this->addSql('ALTER TABLE sygdob_role_sygdob_user DROP FOREIGN KEY FK_F0E91BFE226EE256');
        $this->addSql('DROP TABLE sygdob_role');
        $this->addSql('DROP TABLE sygdob_role_sygdob_user');
        $this->addSql('DROP TABLE sygdob_user');
    }
}
