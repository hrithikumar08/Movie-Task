<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230918115731 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create Director Details Table';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(
            'CREATE TABLE director_details (
                director_id int(10) NOT NULL AUTO_INCREMENT,
                director_name varchar(255) DEFAULT NULL,
                PRIMARY KEY (director_id),
                KEY director_name (director_name)
              ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8'
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $schema->dropTable('director_details');
    }
}
