<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210408202702 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE accounts DROP CONSTRAINT fk_cac89eac67b3b43d');
        $this->addSql('ALTER TABLE messages DROP CONSTRAINT fk_db021e96cc5e8ce8');
        $this->addSql('ALTER TABLE users DROP CONSTRAINT fk_1483a5e938c751c4');
        $this->addSql('DROP SEQUENCE accounts_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE messages_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE roles_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE users_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE roles_id_seq1 CASCADE');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE accounts');
        $this->addSql('DROP TABLE messages');
        $this->addSql('DROP TABLE roles');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE accounts_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE messages_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE roles_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE users_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE roles_id_seq1 INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE users (id SERIAL NOT NULL, roles_id INT DEFAULT NULL, login VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, join_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_1483a5e938c751c4 ON users (roles_id)');
        $this->addSql('CREATE TABLE accounts (id SERIAL NOT NULL, users_id INT NOT NULL, name VARCHAR(255) NOT NULL, join_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_cac89eac67b3b43d ON accounts (users_id)');
        $this->addSql('CREATE TABLE messages (id SERIAL NOT NULL, accounts_id INT NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, message TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_db021e96cc5e8ce8 ON messages (accounts_id)');
        $this->addSql('CREATE TABLE roles (id SERIAL NOT NULL, name VARCHAR(25) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT fk_1483a5e938c751c4 FOREIGN KEY (roles_id) REFERENCES roles (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE accounts ADD CONSTRAINT fk_cac89eac67b3b43d FOREIGN KEY (users_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE messages ADD CONSTRAINT fk_db021e96cc5e8ce8 FOREIGN KEY (accounts_id) REFERENCES accounts (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
