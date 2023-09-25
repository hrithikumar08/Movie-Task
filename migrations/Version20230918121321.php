<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230918121321 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create Crew Table';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(
            'CREATE TABLE crew (
                crew_id int(11) NOT NULL AUTO_INCREMENT,
                crew_name varchar(255) DEFAULT NULL,
                crew_role varchar(255) DEFAULT NULL,
                movie_id int(10) DEFAULT 0,
                PRIMARY KEY (crew_id),
                KEY crew_name (crew_name),
                KEY crew_role (crew_role),
                FOREIGN KEY (movie_id) REFERENCES movie(movie_id)
              ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8'
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $schema->dropTable('crew');
    }
}
