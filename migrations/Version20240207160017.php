<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240207160017 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vehicules DROP FOREIGN KEY Garage');
        $this->addSql('DROP TABLE garage');
        $this->addSql('ALTER TABLE vehicules ADD equipments LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', DROP Mileage, CHANGE Price price DOUBLE PRECISION NOT NULL, CHANGE Caracteristics caracteristics LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', CHANGE CreatedAt created_at DATETIME NOT NULL, CHANGE UpdatedAt updated_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE garage (Id INT NOT NULL, Name VARCHAR(32) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, Description LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, CreatedAt DATETIME NOT NULL, UpdatedAt DATETIME DEFAULT NULL, PRIMARY KEY(Id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE vehicules ADD Mileage INT NOT NULL, DROP equipments, CHANGE price Price INT NOT NULL, CHANGE caracteristics Caracteristics LONGTEXT NOT NULL, CHANGE created_at CreatedAt DATETIME NOT NULL, CHANGE updated_at UpdatedAt DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE vehicules ADD CONSTRAINT Garage FOREIGN KEY (Id) REFERENCES garage (Id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
