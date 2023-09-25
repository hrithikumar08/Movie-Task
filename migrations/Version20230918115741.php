<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230918115741 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create Category Table';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(
            'CREATE TABLE category (
                category_id int(10) NOT NULL AUTO_INCREMENT,
                category_name varchar(255) DEFAULT NULL,
                PRIMARY KEY (category_id),
                KEY category_name (category_name)
              ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8'
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $schema->dropTable('category');
    }
}
