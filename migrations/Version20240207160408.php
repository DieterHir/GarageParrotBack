<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240207160408 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vehicules ADD garage_id INT NOT NULL');
        $this->addSql('ALTER TABLE vehicules ADD CONSTRAINT FK_78218C2DC4FFF555 FOREIGN KEY (garage_id) REFERENCES garage (id)');
        $this->addSql('CREATE INDEX IDX_78218C2DC4FFF555 ON vehicules (garage_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vehicules DROP FOREIGN KEY FK_78218C2DC4FFF555');
        $this->addSql('DROP INDEX IDX_78218C2DC4FFF555 ON vehicules');
        $this->addSql('ALTER TABLE vehicules DROP garage_id');
    }
}
