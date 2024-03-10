<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240309175451_AddJobOffer extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE job_offer (id BLOB NOT NULL --(DC2Type:uuid)
        , france_travail_id VARCHAR(7) NOT NULL, label VARCHAR(255) DEFAULT NULL, description CLOB DEFAULT NULL, company_name VARCHAR(255) DEFAULT NULL, contract_type VARCHAR(10) DEFAULT NULL, apply_url VARCHAR(255) DEFAULT NULL, salary VARCHAR(255) DEFAULT NULL, activity_sector VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE job_offer');
    }
}
