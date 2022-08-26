<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220725080632 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE students_grades_classes DROP FOREIGN KEY FK_6C5E5DD51347DEB2');
        $this->addSql('ALTER TABLE students_grades_course DROP FOREIGN KEY FK_CEBB982E1347DEB2');
        $this->addSql('ALTER TABLE students_grades_student DROP FOREIGN KEY FK_D9908C231347DEB2');
        $this->addSql('CREATE TABLE student_course (student_id INT NOT NULL, course_id INT NOT NULL, INDEX IDX_98A8B739CB944F1A (student_id), INDEX IDX_98A8B739591CC992 (course_id), PRIMARY KEY(student_id, course_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE student_course ADD CONSTRAINT FK_98A8B739CB944F1A FOREIGN KEY (student_id) REFERENCES student (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE student_course ADD CONSTRAINT FK_98A8B739591CC992 FOREIGN KEY (course_id) REFERENCES course (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE students_grades');
        $this->addSql('DROP TABLE students_grades_classes');
        $this->addSql('DROP TABLE students_grades_course');
        $this->addSql('DROP TABLE students_grades_student');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE students_grades (id INT AUTO_INCREMENT NOT NULL, grades DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE students_grades_classes (students_grades_id INT NOT NULL, classes_id INT NOT NULL, INDEX IDX_6C5E5DD51347DEB2 (students_grades_id), INDEX IDX_6C5E5DD59E225B24 (classes_id), PRIMARY KEY(students_grades_id, classes_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE students_grades_course (students_grades_id INT NOT NULL, course_id INT NOT NULL, INDEX IDX_CEBB982E1347DEB2 (students_grades_id), INDEX IDX_CEBB982E591CC992 (course_id), PRIMARY KEY(students_grades_id, course_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE students_grades_student (students_grades_id INT NOT NULL, student_id INT NOT NULL, INDEX IDX_D9908C231347DEB2 (students_grades_id), INDEX IDX_D9908C23CB944F1A (student_id), PRIMARY KEY(students_grades_id, student_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE students_grades_classes ADD CONSTRAINT FK_6C5E5DD51347DEB2 FOREIGN KEY (students_grades_id) REFERENCES students_grades (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE students_grades_classes ADD CONSTRAINT FK_6C5E5DD59E225B24 FOREIGN KEY (classes_id) REFERENCES classes (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE students_grades_course ADD CONSTRAINT FK_CEBB982E1347DEB2 FOREIGN KEY (students_grades_id) REFERENCES students_grades (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE students_grades_course ADD CONSTRAINT FK_CEBB982E591CC992 FOREIGN KEY (course_id) REFERENCES course (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE students_grades_student ADD CONSTRAINT FK_D9908C231347DEB2 FOREIGN KEY (students_grades_id) REFERENCES students_grades (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE students_grades_student ADD CONSTRAINT FK_D9908C23CB944F1A FOREIGN KEY (student_id) REFERENCES student (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('DROP TABLE student_course');
    }
}
