<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220804103201 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE classes ADD created_date DATETIME NOT NULL, ADD modified_date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE course ADD created_date DATETIME NOT NULL, ADD modified_date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE student ADD created_date DATETIME NOT NULL, ADD modified_date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE studentgrades ADD created_date DATETIME NOT NULL, ADD modified_date DATETIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE classes DROP created_date, DROP modified_date');
        $this->addSql('ALTER TABLE course DROP created_date, DROP modified_date');
        $this->addSql('ALTER TABLE student DROP created_date, DROP modified_date');
        $this->addSql('ALTER TABLE studentgrades DROP created_date, DROP modified_date');
    }
}
