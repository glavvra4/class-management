<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240419225037 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Создание таблицы для сущности Fundraising';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<SQL
CREATE SEQUENCE fundraising_id_seq INCREMENT BY 1 MINVALUE 1 START 1
SQL);
        $this->addSql(<<<SQL
CREATE TABLE fundraising (
    id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    amount NUMERIC(20, 2) NOT NULL,
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
DROP SEQUENCE fundraising_id_seq CASCADE
SQL);
        $this->addSql(<<<SQL
DROP TABLE fundraising
SQL);
    }
}
