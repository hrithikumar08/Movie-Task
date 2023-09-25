<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230918121328 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create Movie Media Table';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(
            'CREATE TABLE movie_media (
                media_id int(10) NOT NULL AUTO_INCREMENT,
                movie_id int(10) DEFAULT 0,
                image_name varchar(255) DEFAULT NULL,
                video_name varchar(255) DEFAULT NULL,
                PRIMARY KEY (media_id),
                FOREIGN KEY (movie_id) REFERENCES movie(movie_id),
                KEY image_name (image_name),
                KEY video_name (video_name)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8'
        );


    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $schema->dropTable('movie_media');
    }
}
