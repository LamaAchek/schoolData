<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220804104302 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE classes CHANGE created_date created_date DATETIME DEFAULT NULL, CHANGE modified_date modified_date DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE course CHANGE created_date created_date DATETIME DEFAULT NULL, CHANGE modified_date modified_date DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE student ADD created_date DATETIME DEFAULT NULL, ADD modified_date DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE studentgrades CHANGE created_date created_date DATETIME DEFAULT NULL, CHANGE modified_date modified_date DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE classes CHANGE created_date created_date DATETIME NOT NULL, CHANGE modified_date modified_date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE course CHANGE created_date created_date DATETIME NOT NULL, CHANGE modified_date modified_date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE student DROP created_date, DROP modified_date');
        $this->addSql('ALTER TABLE studentgrades CHANGE created_date created_date DATETIME NOT NULL, CHANGE modified_date modified_date DATETIME NOT NULL');
    }
}
