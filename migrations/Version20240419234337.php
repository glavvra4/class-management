<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240419234337 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Создание таблицы для сущности Contribution';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<SQL
CREATE SEQUENCE contribution_id_seq
    INCREMENT BY 1
    MINVALUE 1
    START 1
SQL);
        $this->addSql(<<<SQL
CREATE TABLE contribution (
    id INT NOT NULL,
    fundraising_id INT NOT NULL,
    student_id INT NOT NULL,
    created_at DATE NOT NULL,
    amount NUMERIC(20, 2) NOT NULL,
    PRIMARY KEY(id)
                          )
SQL);
        $this->addSql(<<<SQL
CREATE INDEX IDX_CONTRIBUTION_FUNDRAISING_ID ON contribution (fundraising_id)
SQL);
        $this->addSql(<<<SQL
CREATE INDEX IDX_CONTRIBUTION_STUDENT_ID ON contribution (student_id)
SQL);
        $this->addSql(<<<SQL
COMMENT ON COLUMN contribution.created_at IS '(DC2Type:date_immutable)'
SQL);
        $this->addSql(<<<SQL
ALTER TABLE contribution ADD CONSTRAINT FK_CONTRIBUTION_FUNDRAISING_ID FOREIGN KEY (fundraising_id) REFERENCES fundraising (id) NOT DEFERRABLE INITIALLY IMMEDIATE
SQL);
        $this->addSql(<<<SQL
ALTER TABLE contribution ADD CONSTRAINT FK_CONTRIBUTION_CUSTOMER_ID FOREIGN KEY (student_id) REFERENCES student (id) NOT DEFERRABLE INITIALLY IMMEDIATE
SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql(<<<SQL
CREATE SCHEMA public
SQL);
        $this->addSql(<<<SQL
DROP SEQUENCE contribution_id_seq CASCADE
SQL);
        $this->addSql(<<<SQL
ALTER TABLE contribution DROP CONSTRAINT FK_CONTRIBUTION_FUNDRAISING_ID
SQL);
        $this->addSql(<<<SQL
ALTER TABLE contribution DROP CONSTRAINT FK_CONTRIBUTION_CUSTOMER_ID
SQL);
        $this->addSql(<<<SQL
DROP TABLE contribution
SQL);
    }
}
