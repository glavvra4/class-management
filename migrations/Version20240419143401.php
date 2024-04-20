<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240419143401 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Создание таблицы для сущности Student';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<SQL
CREATE SEQUENCE student_id_seq
    INCREMENT BY 1
    MINVALUE 1
    START 1
SQL);
        $this->addSql(<<<SQL
CREATE TABLE student (
    id INT NOT NULL,
    firstname VARCHAR(255) NOT NULL,
    lastname VARCHAR(255) NOT NULL,
    birthdate DATE NOT NULL,
    created_at DATE NOT NULL,
    deleted_at DATE DEFAULT NULL,
    PRIMARY KEY(id)
                     )
SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql(<<<SQL
CREATE SCHEMA public
SQL);
        $this->addSql(<<<SQL
DROP SEQUENCE student_id_seq CASCADE
SQL);
        $this->addSql(<<<SQL
DROP TABLE student
SQL);
    }
}
