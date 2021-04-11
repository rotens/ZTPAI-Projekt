<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210406154642 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE IF NOT EXISTS accounts_id_seq');
        $this->addSql('SELECT setval(\'accounts_id_seq\', (SELECT MAX(id) FROM accounts))');
        $this->addSql('ALTER TABLE accounts ALTER id SET DEFAULT nextval(\'accounts_id_seq\')');
        $this->addSql('CREATE SEQUENCE IF NOT EXISTS messages_id_seq');
        $this->addSql('SELECT setval(\'messages_id_seq\', (SELECT MAX(id) FROM messages))');
        $this->addSql('ALTER TABLE messages ALTER id SET DEFAULT nextval(\'messages_id_seq\')');
        $this->addSql('CREATE SEQUENCE IF NOT EXISTS roles_id_seq');
        $this->addSql('SELECT setval(\'roles_id_seq\', (SELECT MAX(id) FROM roles))');
        $this->addSql('ALTER TABLE roles ALTER id SET DEFAULT nextval(\'roles_id_seq\')');
        $this->addSql('CREATE SEQUENCE IF NOT EXISTS users_id_seq');
        $this->addSql('SELECT setval(\'users_id_seq\', (SELECT MAX(id) FROM users))');
        $this->addSql('ALTER TABLE users ALTER id SET DEFAULT nextval(\'users_id_seq\')');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE roles ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE users ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE accounts ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE messages ALTER id DROP DEFAULT');
    }
}
