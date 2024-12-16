<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241212103558 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sweat_size DROP FOREIGN KEY FK_2388FDC4EF044C42');
        $this->addSql('DROP TABLE sweat_size');
        $this->addSql('ALTER TABLE sweat_shirt ADD stock_xs INT DEFAULT NULL, ADD stock_s INT NOT NULL, ADD stock_m INT NOT NULL, ADD stock_l INT NOT NULL, ADD stock_xl INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE sweat_size (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, stock INT NOT NULL, sweat_id INT DEFAULT NULL, INDEX IDX_2388FDC4EF044C42 (sweat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE sweat_size ADD CONSTRAINT FK_2388FDC4EF044C42 FOREIGN KEY (sweat_id) REFERENCES sweat_shirt (id)');
        $this->addSql('ALTER TABLE sweat_shirt DROP stock_xs, DROP stock_s, DROP stock_m, DROP stock_l, DROP stock_xl');
    }
}
