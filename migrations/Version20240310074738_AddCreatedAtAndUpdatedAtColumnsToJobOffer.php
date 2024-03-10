<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240310074738_AddCreatedAtAndUpdatedAtColumnsToJobOffer extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE job_offer ADD COLUMN created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE job_offer ADD COLUMN updated_at DATETIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__job_offer AS SELECT id, france_travail_id, label, description, company_name, contract_type, apply_url, salary, activity_sector FROM job_offer');
        $this->addSql('DROP TABLE job_offer');
        $this->addSql('CREATE TABLE job_offer (id BLOB NOT NULL --(DC2Type:uuid)
        , france_travail_id VARCHAR(7) NOT NULL, label VARCHAR(255) DEFAULT NULL, description CLOB DEFAULT NULL, company_name VARCHAR(255) DEFAULT NULL, contract_type VARCHAR(10) DEFAULT NULL, apply_url VARCHAR(255) DEFAULT NULL, salary VARCHAR(255) DEFAULT NULL, activity_sector VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO job_offer (id, france_travail_id, label, description, company_name, contract_type, apply_url, salary, activity_sector) SELECT id, france_travail_id, label, description, company_name, contract_type, apply_url, salary, activity_sector FROM __temp__job_offer');
        $this->addSql('DROP TABLE __temp__job_offer');
    }
}
