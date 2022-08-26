<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220714102829 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE classes (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, section VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE course (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, dob DATETIME NOT NULL, imagepath VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE students_grades (id INT AUTO_INCREMENT NOT NULL, grades DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE students_grades_student (students_grades_id INT NOT NULL, student_id INT NOT NULL, INDEX IDX_D9908C231347DEB2 (students_grades_id), INDEX IDX_D9908C23CB944F1A (student_id), PRIMARY KEY(students_grades_id, student_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE students_grades_course (students_grades_id INT NOT NULL, course_id INT NOT NULL, INDEX IDX_CEBB982E1347DEB2 (students_grades_id), INDEX IDX_CEBB982E591CC992 (course_id), PRIMARY KEY(students_grades_id, course_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE students_grades_classes (students_grades_id INT NOT NULL, classes_id INT NOT NULL, INDEX IDX_6C5E5DD51347DEB2 (students_grades_id), INDEX IDX_6C5E5DD59E225B24 (classes_id), PRIMARY KEY(students_grades_id, classes_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE students_grades_student ADD CONSTRAINT FK_D9908C231347DEB2 FOREIGN KEY (students_grades_id) REFERENCES students_grades (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE students_grades_student ADD CONSTRAINT FK_D9908C23CB944F1A FOREIGN KEY (student_id) REFERENCES student (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE students_grades_course ADD CONSTRAINT FK_CEBB982E1347DEB2 FOREIGN KEY (students_grades_id) REFERENCES students_grades (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE students_grades_course ADD CONSTRAINT FK_CEBB982E591CC992 FOREIGN KEY (course_id) REFERENCES course (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE students_grades_classes ADD CONSTRAINT FK_6C5E5DD51347DEB2 FOREIGN KEY (students_grades_id) REFERENCES students_grades (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE students_grades_classes ADD CONSTRAINT FK_6C5E5DD59E225B24 FOREIGN KEY (classes_id) REFERENCES classes (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE students_grades_classes DROP FOREIGN KEY FK_6C5E5DD59E225B24');
        $this->addSql('ALTER TABLE students_grades_course DROP FOREIGN KEY FK_CEBB982E591CC992');
        $this->addSql('ALTER TABLE students_grades_student DROP FOREIGN KEY FK_D9908C23CB944F1A');
        $this->addSql('ALTER TABLE students_grades_student DROP FOREIGN KEY FK_D9908C231347DEB2');
        $this->addSql('ALTER TABLE students_grades_course DROP FOREIGN KEY FK_CEBB982E1347DEB2');
        $this->addSql('ALTER TABLE students_grades_classes DROP FOREIGN KEY FK_6C5E5DD51347DEB2');
        $this->addSql('DROP TABLE classes');
        $this->addSql('DROP TABLE course');
        $this->addSql('DROP TABLE student');
        $this->addSql('DROP TABLE students_grades');
        $this->addSql('DROP TABLE students_grades_student');
        $this->addSql('DROP TABLE students_grades_course');
        $this->addSql('DROP TABLE students_grades_classes');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
