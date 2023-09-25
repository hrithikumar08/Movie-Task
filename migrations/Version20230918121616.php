<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230918121616 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create Movie Rating Table';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(
            'CREATE TABLE movie_rating (
                rating_id int(10) NOT NULL AUTO_INCREMENT,
                rating int(10) DEFAULT 0,
                user_id int(10) DEFAULT 0,
                movie_id int(10) DEFAULT 0,
                comment varchar(255) DEFAULT 0,
                comment_date datetime DEFAULT NULL,
                PRIMARY KEY (rating_id),
                FOREIGN KEY (user_id) REFERENCES users(id),
                FOREIGN KEY (movie_id) REFERENCES movie(movie_id),
                KEY comment_date (comment_date)
              ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8'
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $schema->dropTable('movie_rating');
    }
}
