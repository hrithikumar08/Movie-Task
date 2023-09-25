<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230918121049 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create Movie Table';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(
            'CREATE TABLE movie (
                movie_id int(10) NOT NULL AUTO_INCREMENT,
                title varchar(255) DEFAULT NULL,
                director_id int(10) DEFAULT 0,
                category_id int(10) DEFAULT 0,
                budget int(10) DEFAULT 0,
                addeddate datetime DEFAULT NULL,
                PRIMARY KEY (movie_id),
                KEY title (title),
                FOREIGN KEY (director_id) REFERENCES director_details(director_id),
                FOREIGN KEY (category_id) REFERENCES category(category_id),
                KEY addeddate (addeddate)
              ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8'
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $schema->dropTable('movie');
    }
}
