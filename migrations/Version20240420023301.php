<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240420023301 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Добавлена связь Many-To-Many между Fundraising и Student';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<SQL
CREATE TABLE fundraising_student (
    fundraising_id INT NOT NULL,
    student_id INT NOT NULL,
    PRIMARY KEY(fundraising_id, student_id)
                                 )
SQL);
        $this->addSql(<<<SQL
CREATE INDEX IDX_FUNDRAISING_STUDENT_FUNDRAISING_ID ON fundraising_student (fundraising_id)
SQL);
        $this->addSql(<<<SQL
CREATE INDEX IDX_FUNDRAISING_STUDENT_STUDENT_ID ON fundraising_student (student_id)
SQL);
        $this->addSql(<<<SQL
ALTER TABLE fundraising_student ADD CONSTRAINT FK_FUNDRAISING_STUDENT_FUNDRAISING_ID FOREIGN KEY (fundraising_id) REFERENCES fundraising (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
SQL);
        $this->addSql(<<<SQL
ALTER TABLE fundraising_student ADD CONSTRAINT FK_FUNDRAISING_STUDENT_STUDENT_ID FOREIGN KEY (student_id) REFERENCES student (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql(<<<SQL
CREATE SCHEMA public
SQL);
        $this->addSql(<<<SQL
ALTER TABLE fundraising_student DROP CONSTRAINT FK_C13DA493BE99DD21
SQL);
        $this->addSql(<<<SQL
ALTER TABLE fundraising_student DROP CONSTRAINT FK_C13DA493CB944F1A
SQL);
        $this->addSql(<<<SQL
DROP TABLE fundraising_student
SQL);
    }
}
