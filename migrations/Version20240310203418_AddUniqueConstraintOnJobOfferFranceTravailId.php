<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240310203418_AddUniqueConstraintOnJobOfferFranceTravailId extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__job_offer AS SELECT id, france_travail_id, label, description, company_name, contract_type, apply_url, salary, activity_sector, created_at, updated_at FROM job_offer');
        $this->addSql('DROP TABLE job_offer');
        $this->addSql('CREATE TABLE job_offer (id BLOB NOT NULL --(DC2Type:uuid)
        , france_travail_id VARCHAR(10) NOT NULL, label VARCHAR(255) DEFAULT NULL, description CLOB DEFAULT NULL, company_name VARCHAR(255) DEFAULT NULL, contract_type VARCHAR(10) DEFAULT NULL, apply_url VARCHAR(255) DEFAULT NULL, salary VARCHAR(255) DEFAULT NULL, activity_sector VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , PRIMARY KEY(id))');
        $this->addSql('INSERT INTO job_offer (id, france_travail_id, label, description, company_name, contract_type, apply_url, salary, activity_sector, created_at, updated_at) SELECT id, france_travail_id, label, description, company_name, contract_type, apply_url, salary, activity_sector, created_at, updated_at FROM __temp__job_offer');
        $this->addSql('DROP TABLE __temp__job_offer');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_288A3A4E1C8151D6 ON job_offer (france_travail_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__job_offer AS SELECT id, france_travail_id, label, description, company_name, contract_type, apply_url, salary, activity_sector, created_at, updated_at FROM job_offer');
        $this->addSql('DROP TABLE job_offer');
        $this->addSql('CREATE TABLE job_offer (id BLOB NOT NULL --(DC2Type:uuid)
        , france_travail_id VARCHAR(7) NOT NULL, label VARCHAR(255) DEFAULT NULL, description CLOB DEFAULT NULL, company_name VARCHAR(255) DEFAULT NULL, contract_type VARCHAR(10) DEFAULT NULL, apply_url VARCHAR(255) DEFAULT NULL, salary VARCHAR(255) DEFAULT NULL, activity_sector VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO job_offer (id, france_travail_id, label, description, company_name, contract_type, apply_url, salary, activity_sector, created_at, updated_at) SELECT id, france_travail_id, label, description, company_name, contract_type, apply_url, salary, activity_sector, created_at, updated_at FROM __temp__job_offer');
        $this->addSql('DROP TABLE __temp__job_offer');
    }
}
