<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240420010130 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Создание таблицы для сущности Expenditure';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<SQL
CREATE SEQUENCE expenditure_id_seq
    INCREMENT BY 1
    MINVALUE 1
    START 1
SQL);
        $this->addSql(<<<SQL
CREATE TABLE expenditure (
    id INT NOT NULL,
    fundraising_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    amount NUMERIC(20, 2) NOT NULL,
    created_at DATE NOT NULL,
    PRIMARY KEY(id)
                         )
SQL);
        $this->addSql(<<<SQL
CREATE INDEX IDX_EXPENDITURE_FUNDRAISING_ID ON expenditure (fundraising_id)
SQL);
        $this->addSql(<<<SQL
COMMENT ON COLUMN expenditure.created_at IS '(DC2Type:date_immutable)'
SQL);
        $this->addSql(<<<SQL
ALTER TABLE expenditure ADD CONSTRAINT FK_EXPENDITURE_FUNDRAISING_ID FOREIGN KEY (fundraising_id) REFERENCES fundraising (id) NOT DEFERRABLE INITIALLY IMMEDIATE
SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql(<<<SQL
CREATE SCHEMA public
SQL);
        $this->addSql(<<<SQL
DROP SEQUENCE expenditure_id_seq CASCADE
SQL);
        $this->addSql(<<<SQL
ALTER TABLE expenditure DROP CONSTRAINT FK_EXPENDITURE_FUNDRAISING_ID
SQL);
        $this->addSql(<<<SQL
DROP TABLE expenditure
SQL);
    }
}
