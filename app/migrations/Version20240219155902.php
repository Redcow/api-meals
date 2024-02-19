<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240219155902 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE meal ADD cook_id INT NOT NULL');
        $this->addSql('ALTER TABLE meal ADD CONSTRAINT FK_9EF68E9CB0D5B835 FOREIGN KEY (cook_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_9EF68E9CB0D5B835 ON meal (cook_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE meal DROP FOREIGN KEY FK_9EF68E9CB0D5B835');
        $this->addSql('DROP INDEX IDX_9EF68E9CB0D5B835 ON meal');
        $this->addSql('ALTER TABLE meal DROP cook_id');
    }
}
