<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240205072402 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create houses, apartments, persons tables';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE apartments_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE houses_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE persons_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE apartments (id INT NOT NULL, house_id INT DEFAULT NULL, number VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7745248E6BB74515 ON apartments (house_id)');
        $this->addSql('CREATE UNIQUE INDEX unique_apartment_house ON apartments (number, house_id)');
        $this->addSql('CREATE TABLE houses (id INT NOT NULL, number VARCHAR(100) NOT NULL, street_name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX unique_house_address ON houses (number, street_name)');
        $this->addSql('CREATE TABLE persons (id INT NOT NULL, apartment_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, birthdate TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, personal_id_number VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_A25CC7D3176DFE85 ON persons (apartment_id)');
        $this->addSql('CREATE UNIQUE INDEX unique_personal_id_number ON persons (personal_id_number)');
        $this->addSql('CREATE UNIQUE INDEX unique_person_apartment ON persons (personal_id_number, apartment_id)');
        $this->addSql('COMMENT ON COLUMN persons.birthdate IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE apartments ADD CONSTRAINT FK_7745248E6BB74515 FOREIGN KEY (house_id) REFERENCES houses (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE persons ADD CONSTRAINT FK_A25CC7D3176DFE85 FOREIGN KEY (apartment_id) REFERENCES apartments (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP SEQUENCE apartments_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE houses_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE persons_id_seq CASCADE');
        $this->addSql('ALTER TABLE apartments DROP CONSTRAINT FK_7745248E6BB74515');
        $this->addSql('ALTER TABLE persons DROP CONSTRAINT FK_A25CC7D3176DFE85');
        $this->addSql('DROP TABLE apartments');
        $this->addSql('DROP TABLE houses');
        $this->addSql('DROP TABLE persons');
    }
}
