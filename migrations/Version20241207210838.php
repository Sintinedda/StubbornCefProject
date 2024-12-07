<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241207210838 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE admin_user (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_NAME (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sweat_shirt (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sweat_sizes (id INT AUTO_INCREMENT NOT NULL, size JSON NOT NULL, stock INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sweat_sizes_sweat_shirt (sweat_sizes_id INT NOT NULL, sweat_shirt_id INT NOT NULL, INDEX IDX_F90955A6D4C036AF (sweat_sizes_id), INDEX IDX_F90955A6B8E23E05 (sweat_shirt_id), PRIMARY KEY(sweat_sizes_id, sweat_shirt_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, delivery_address VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_NAME (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sweat_sizes_sweat_shirt ADD CONSTRAINT FK_F90955A6D4C036AF FOREIGN KEY (sweat_sizes_id) REFERENCES sweat_sizes (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sweat_sizes_sweat_shirt ADD CONSTRAINT FK_F90955A6B8E23E05 FOREIGN KEY (sweat_shirt_id) REFERENCES sweat_shirt (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sweat_sizes_sweat_shirt DROP FOREIGN KEY FK_F90955A6D4C036AF');
        $this->addSql('ALTER TABLE sweat_sizes_sweat_shirt DROP FOREIGN KEY FK_F90955A6B8E23E05');
        $this->addSql('DROP TABLE admin_user');
        $this->addSql('DROP TABLE sweat_shirt');
        $this->addSql('DROP TABLE sweat_sizes');
        $this->addSql('DROP TABLE sweat_sizes_sweat_shirt');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
