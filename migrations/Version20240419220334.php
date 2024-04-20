<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240419220334 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Создание таблицы для сущности SonataUser';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<SQL
CREATE SEQUENCE sonata_user_id_seq
    INCREMENT BY 1
    MINVALUE 1
    START 1
SQL);
        $this->addSql(<<<SQL
CREATE TABLE sonata_user (
    id INT NOT NULL,
    username VARCHAR(180) NOT NULL,
    username_canonical VARCHAR(180) NOT NULL,
    email VARCHAR(180) NOT NULL,
    email_canonical VARCHAR(180) NOT NULL,
    enabled BOOLEAN NOT NULL,
    salt VARCHAR(255) DEFAULT NULL,
    password VARCHAR(255) NOT NULL,
    last_login TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL,
    confirmation_token VARCHAR(180) DEFAULT NULL,
    password_requested_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL,
    roles TEXT NOT NULL,
    created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
    updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
    PRIMARY KEY(id)
                         )
SQL);
        $this->addSql(<<<SQL
CREATE UNIQUE INDEX UNIQ_SONATA_USER_USERNAME_CANONICAL ON sonata_user (username_canonical)
SQL);
        $this->addSql(<<<SQL
CREATE UNIQUE INDEX UNIQ_SONATA_USER_EMAIL_CANONICAL ON sonata_user (email_canonical)
SQL);
        $this->addSql(<<<SQL
CREATE UNIQUE INDEX UNIQ_SONATA_USER_CONFIRMATION_TOKEN ON sonata_user (confirmation_token)
SQL);
        $this->addSql(<<<SQL
COMMENT ON COLUMN sonata_user.roles IS '(DC2Type:array)'
SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql(<<<SQL
CREATE SCHEMA public
SQL);
        $this->addSql(<<<SQL
DROP SEQUENCE sonata_user_id_seq CASCADE
SQL);
        $this->addSql(<<<SQL
DROP TABLE sonata_user
SQL);
    }
}
