<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241211142332 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sweat_size_sweat_shirt DROP FOREIGN KEY FK_BBF9A64FB2966F6D');
        $this->addSql('ALTER TABLE sweat_size_sweat_shirt DROP FOREIGN KEY FK_BBF9A64FB8E23E05');
        $this->addSql('DROP TABLE sweat_size_sweat_shirt');
        $this->addSql('ALTER TABLE sweat_size ADD sweat_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sweat_size ADD CONSTRAINT FK_2388FDC4EF044C42 FOREIGN KEY (sweat_id) REFERENCES sweat_shirt (id)');
        $this->addSql('CREATE INDEX IDX_2388FDC4EF044C42 ON sweat_size (sweat_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE sweat_size_sweat_shirt (sweat_size_id INT NOT NULL, sweat_shirt_id INT NOT NULL, INDEX IDX_BBF9A64FB8E23E05 (sweat_shirt_id), INDEX IDX_BBF9A64FB2966F6D (sweat_size_id), PRIMARY KEY(sweat_size_id, sweat_shirt_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE sweat_size_sweat_shirt ADD CONSTRAINT FK_BBF9A64FB2966F6D FOREIGN KEY (sweat_size_id) REFERENCES sweat_size (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sweat_size_sweat_shirt ADD CONSTRAINT FK_BBF9A64FB8E23E05 FOREIGN KEY (sweat_shirt_id) REFERENCES sweat_shirt (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sweat_size DROP FOREIGN KEY FK_2388FDC4EF044C42');
        $this->addSql('DROP INDEX IDX_2388FDC4EF044C42 ON sweat_size');
        $this->addSql('ALTER TABLE sweat_size DROP sweat_id');
    }
}
