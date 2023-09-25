<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230914185847 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create Users Table';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX email ON users');
        $this->addSql('DROP INDEX name ON users');
        $this->addSql('DROP INDEX email_address_unique ON users');
        $this->addSql('DROP INDEX register_date ON users');
        $this->addSql('ALTER TABLE users DROP registerdate, CHANGE email email VARCHAR(45) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users ADD registerdate DATE DEFAULT NULL, CHANGE email email VARCHAR(45) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX email ON users (email)');
        $this->addSql('CREATE INDEX name ON users (name)');
        $this->addSql('CREATE INDEX email_address_unique ON users (email)');
        $this->addSql('CREATE INDEX register_date ON users (registerdate)');
    }
}
