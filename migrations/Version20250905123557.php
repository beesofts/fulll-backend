<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250905123557 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE fleets (id VARCHAR(13) NOT NULL, owner_name VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F3164526C8851D96 ON fleets (owner_name)');
        $this->addSql('CREATE TABLE fleets_vehicles (fleet_id VARCHAR(13) NOT NULL, vehicle_plate_number VARCHAR(13) NOT NULL, PRIMARY KEY(fleet_id, vehicle_plate_number))');
        $this->addSql('CREATE INDEX IDX_3690D9794B061DF9 ON fleets_vehicles (fleet_id)');
        $this->addSql('CREATE INDEX IDX_3690D9794517D8F1 ON fleets_vehicles (vehicle_plate_number)');
        $this->addSql('CREATE TABLE users (name VARCHAR(50) NOT NULL, PRIMARY KEY(name))');
        $this->addSql('CREATE TABLE vehicles (plate_number VARCHAR(13) NOT NULL, location_latitude NUMERIC(10, 0) DEFAULT NULL, location_longitude NUMERIC(10, 0) DEFAULT NULL, PRIMARY KEY(plate_number))');
        $this->addSql('ALTER TABLE fleets ADD CONSTRAINT FK_F3164526C8851D96 FOREIGN KEY (owner_name) REFERENCES users (name) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE fleets_vehicles ADD CONSTRAINT FK_3690D9794B061DF9 FOREIGN KEY (fleet_id) REFERENCES fleets (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE fleets_vehicles ADD CONSTRAINT FK_3690D9794517D8F1 FOREIGN KEY (vehicle_plate_number) REFERENCES vehicles (plate_number) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE fleets DROP CONSTRAINT FK_F3164526C8851D96');
        $this->addSql('ALTER TABLE fleets_vehicles DROP CONSTRAINT FK_3690D9794B061DF9');
        $this->addSql('ALTER TABLE fleets_vehicles DROP CONSTRAINT FK_3690D9794517D8F1');
        $this->addSql('DROP TABLE fleets');
        $this->addSql('DROP TABLE fleets_vehicles');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE vehicles');
    }
}
