<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220315140758 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD hotel_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6499C905093 FOREIGN KEY (hotel_id_id) REFERENCES hotel (id)');
        $this->addSql('CREATE INDEX IDX_8D93D6499C905093 ON user (hotel_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D6499C905093');
        $this->addSql('DROP INDEX IDX_8D93D6499C905093 ON `user`');
        $this->addSql('ALTER TABLE `user` DROP hotel_id_id');
    }
}
