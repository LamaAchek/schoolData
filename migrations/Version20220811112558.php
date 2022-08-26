<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220811112558 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE classes (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, section VARCHAR(255) NOT NULL, created_date DATETIME DEFAULT NULL, modified_date DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE course (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, classes VARCHAR(255) DEFAULT NULL, created_date DATETIME DEFAULT NULL, modified_date DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, dob DATETIME NOT NULL, imagepath VARCHAR(255) DEFAULT NULL, created_date DATETIME DEFAULT NULL, modified_date DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student_course (student_id INT NOT NULL, course_id INT NOT NULL, INDEX IDX_98A8B739CB944F1A (student_id), INDEX IDX_98A8B739591CC992 (course_id), PRIMARY KEY(student_id, course_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student_classes (student_id INT NOT NULL, classes_id INT NOT NULL, INDEX IDX_EFDBCB3DCB944F1A (student_id), INDEX IDX_EFDBCB3D9E225B24 (classes_id), PRIMARY KEY(student_id, classes_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE studentgrades (id INT AUTO_INCREMENT NOT NULL, grades DOUBLE PRECISION NOT NULL, created_date DATETIME DEFAULT NULL, modified_date DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE studentgrades_student (studentgrades_id INT NOT NULL, student_id INT NOT NULL, INDEX IDX_139C498FA2C986A5 (studentgrades_id), INDEX IDX_139C498FCB944F1A (student_id), PRIMARY KEY(studentgrades_id, student_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE studentgrades_course (studentgrades_id INT NOT NULL, course_id INT NOT NULL, INDEX IDX_78BCBEDFA2C986A5 (studentgrades_id), INDEX IDX_78BCBEDF591CC992 (course_id), PRIMARY KEY(studentgrades_id, course_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE studentgrades_classes (studentgrades_id INT NOT NULL, classes_id INT NOT NULL, INDEX IDX_A6529879A2C986A5 (studentgrades_id), INDEX IDX_A65298799E225B24 (classes_id), PRIMARY KEY(studentgrades_id, classes_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE student_course ADD CONSTRAINT FK_98A8B739CB944F1A FOREIGN KEY (student_id) REFERENCES student (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE student_course ADD CONSTRAINT FK_98A8B739591CC992 FOREIGN KEY (course_id) REFERENCES course (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE student_classes ADD CONSTRAINT FK_EFDBCB3DCB944F1A FOREIGN KEY (student_id) REFERENCES student (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE student_classes ADD CONSTRAINT FK_EFDBCB3D9E225B24 FOREIGN KEY (classes_id) REFERENCES classes (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE studentgrades_student ADD CONSTRAINT FK_139C498FA2C986A5 FOREIGN KEY (studentgrades_id) REFERENCES studentgrades (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE studentgrades_student ADD CONSTRAINT FK_139C498FCB944F1A FOREIGN KEY (student_id) REFERENCES student (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE studentgrades_course ADD CONSTRAINT FK_78BCBEDFA2C986A5 FOREIGN KEY (studentgrades_id) REFERENCES studentgrades (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE studentgrades_course ADD CONSTRAINT FK_78BCBEDF591CC992 FOREIGN KEY (course_id) REFERENCES course (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE studentgrades_classes ADD CONSTRAINT FK_A6529879A2C986A5 FOREIGN KEY (studentgrades_id) REFERENCES studentgrades (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE studentgrades_classes ADD CONSTRAINT FK_A65298799E225B24 FOREIGN KEY (classes_id) REFERENCES classes (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE student_classes DROP FOREIGN KEY FK_EFDBCB3D9E225B24');
        $this->addSql('ALTER TABLE studentgrades_classes DROP FOREIGN KEY FK_A65298799E225B24');
        $this->addSql('ALTER TABLE student_course DROP FOREIGN KEY FK_98A8B739591CC992');
        $this->addSql('ALTER TABLE studentgrades_course DROP FOREIGN KEY FK_78BCBEDF591CC992');
        $this->addSql('ALTER TABLE student_course DROP FOREIGN KEY FK_98A8B739CB944F1A');
        $this->addSql('ALTER TABLE student_classes DROP FOREIGN KEY FK_EFDBCB3DCB944F1A');
        $this->addSql('ALTER TABLE studentgrades_student DROP FOREIGN KEY FK_139C498FCB944F1A');
        $this->addSql('ALTER TABLE studentgrades_student DROP FOREIGN KEY FK_139C498FA2C986A5');
        $this->addSql('ALTER TABLE studentgrades_course DROP FOREIGN KEY FK_78BCBEDFA2C986A5');
        $this->addSql('ALTER TABLE studentgrades_classes DROP FOREIGN KEY FK_A6529879A2C986A5');
        $this->addSql('DROP TABLE classes');
        $this->addSql('DROP TABLE course');
        $this->addSql('DROP TABLE student');
        $this->addSql('DROP TABLE student_course');
        $this->addSql('DROP TABLE student_classes');
        $this->addSql('DROP TABLE studentgrades');
        $this->addSql('DROP TABLE studentgrades_student');
        $this->addSql('DROP TABLE studentgrades_course');
        $this->addSql('DROP TABLE studentgrades_classes');
        $this->addSql('DROP TABLE user');
    }
}
