<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200419045210 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE primary_school (id VARCHAR(15) NOT NULL, drenddn_id VARCHAR(15) NOT NULL, iepp_id VARCHAR(15) NOT NULL, schoolname VARCHAR(255) NOT NULL, INDEX IDX_169620B1B7FBE9B (drenddn_id), INDEX IDX_169620BD09614D0 (iepp_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE primary_school ADD CONSTRAINT FK_169620B1B7FBE9B FOREIGN KEY (drenddn_id) REFERENCES drenddn (id)');
        $this->addSql('ALTER TABLE primary_school ADD CONSTRAINT FK_169620BD09614D0 FOREIGN KEY (iepp_id) REFERENCES iepp (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE primary_school');
    }
}
