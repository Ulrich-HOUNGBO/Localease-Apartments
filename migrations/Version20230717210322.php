<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230717210322 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE property_feature (property_id INT NOT NULL, feature_id INT NOT NULL, INDEX IDX_461A3F1E549213EC (property_id), INDEX IDX_461A3F1E60E4B879 (feature_id), PRIMARY KEY(property_id, feature_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE property_feature ADD CONSTRAINT FK_461A3F1E549213EC FOREIGN KEY (property_id) REFERENCES property (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE property_feature ADD CONSTRAINT FK_461A3F1E60E4B879 FOREIGN KEY (feature_id) REFERENCES feature (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE property_feature DROP FOREIGN KEY FK_461A3F1E549213EC');
        $this->addSql('ALTER TABLE property_feature DROP FOREIGN KEY FK_461A3F1E60E4B879');
        $this->addSql('DROP TABLE property_feature');
    }
}
