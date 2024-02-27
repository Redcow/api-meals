<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240227092141 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, quantity SMALLINT NOT NULL, name VARCHAR(127) NOT NULL, price INT NOT NULL, meal_id INT DEFAULT NULL, order_id INT NOT NULL, INDEX IDX_23A0E66639666D6 (meal_id), INDEX IDX_23A0E668D9F6D38 (order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8');
        $this->addSql('CREATE TABLE client_user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, username VARCHAR(50) NOT NULL, UNIQUE INDEX UNIQ_5C0F152BE7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8');
        $this->addSql('CREATE TABLE cook_user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, username VARCHAR(50) NOT NULL, UNIQUE INDEX UNIQ_83758902E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8');
        $this->addSql('CREATE TABLE meal (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(127) NOT NULL, price INT NOT NULL, description LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, quantity SMALLINT NOT NULL, cook_id INT NOT NULL, INDEX IDX_9EF68E9CB0D5B835 (cook_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, add_at DATETIME NOT NULL, status VARCHAR(31) NOT NULL, client_id INT NOT NULL, INDEX IDX_F529939819EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66639666D6 FOREIGN KEY (meal_id) REFERENCES meal (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E668D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE meal ADD CONSTRAINT FK_9EF68E9CB0D5B835 FOREIGN KEY (cook_id) REFERENCES cook_user (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F529939819EB6921 FOREIGN KEY (client_id) REFERENCES client_user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66639666D6');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E668D9F6D38');
        $this->addSql('ALTER TABLE meal DROP FOREIGN KEY FK_9EF68E9CB0D5B835');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F529939819EB6921');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE client_user');
        $this->addSql('DROP TABLE cook_user');
        $this->addSql('DROP TABLE meal');
        $this->addSql('DROP TABLE `order`');
    }
}
