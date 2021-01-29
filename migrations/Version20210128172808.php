<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210128172808 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE gift (
            id INT AUTO_INCREMENT NOT NULL, 
            uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', 
            code VARCHAR(255) NOT NULL,
            description LONGTEXT DEFAULT NULL, 
            price DOUBLE PRECISION NOT NULL, 
            receiver_uuid VARCHAR(255) NOT NULL, 
            receiver_first_name VARCHAR(255) NOT NULL, 
            receiver_last_name VARCHAR(255) NOT NULL, 
            country_code VARCHAR(255) NOT NULL, 
            created_at DATETIME NOT NULL, 
            updated_at DATETIME NOT NULL, 
            UNIQUE INDEX UNIQ_A47C990DD17F50A6 (uuid), 
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE gift');
    }
}
