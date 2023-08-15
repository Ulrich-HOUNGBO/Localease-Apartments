<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230713111602 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE illustration ADD property_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE illustration ADD CONSTRAINT FK_D67B9A42549213EC FOREIGN KEY (property_id) REFERENCES property (id)');
        $this->addSql('CREATE INDEX IDX_D67B9A42549213EC ON illustration (property_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE illustration DROP FOREIGN KEY FK_D67B9A42549213EC');
        $this->addSql('DROP INDEX IDX_D67B9A42549213EC ON illustration');
        $this->addSql('ALTER TABLE illustration DROP property_id');
    }
}
