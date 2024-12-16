<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241212110115 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sweat_shirt CHANGE stock_xs stock_xs INT NOT NULL, CHANGE stock_s stock_s INT NOT NULL, CHANGE stock_m stock_m INT NOT NULL, CHANGE stock_l stock_l INT NOT NULL, CHANGE stock_xl stock_xl INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sweat_shirt CHANGE stock_xs stock_xs INT DEFAULT 0 NOT NULL, CHANGE stock_s stock_s INT DEFAULT 0 NOT NULL, CHANGE stock_m stock_m INT DEFAULT 0 NOT NULL, CHANGE stock_l stock_l INT DEFAULT 0 NOT NULL, CHANGE stock_xl stock_xl INT DEFAULT 0 NOT NULL');
    }
}
