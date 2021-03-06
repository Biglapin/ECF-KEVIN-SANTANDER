<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220315200052 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE room ADD hotel_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE room ADD CONSTRAINT FK_729F519B9C905093 FOREIGN KEY (hotel_id_id) REFERENCES hotel (id)');
        $this->addSql('CREATE INDEX IDX_729F519B9C905093 ON room (hotel_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE room DROP FOREIGN KEY FK_729F519B9C905093');
        $this->addSql('DROP INDEX IDX_729F519B9C905093 ON room');
        $this->addSql('ALTER TABLE room DROP hotel_id_id');
    }
}
