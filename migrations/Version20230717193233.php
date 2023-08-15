<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230717193233 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE city ADD content_url VARCHAR(255) DEFAULT NULL, ADD file_path VARCHAR(255) DEFAULT NULL, DROP image_city_file, DROP image_city_name');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE city ADD image_city_file VARCHAR(255) DEFAULT NULL, ADD image_city_name VARCHAR(255) DEFAULT NULL, DROP content_url, DROP file_path');
    }
}
