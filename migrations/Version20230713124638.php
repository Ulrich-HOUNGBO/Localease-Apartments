<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230713124638 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE property ADD type_id INT DEFAULT NULL, ADD status_id INT DEFAULT NULL, ADD price INT NOT NULL');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDEC54C8C93 FOREIGN KEY (type_id) REFERENCES property_type (id)');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDE6BF700BD FOREIGN KEY (status_id) REFERENCES property_status (id)');
        $this->addSql('CREATE INDEX IDX_8BF21CDEC54C8C93 ON property (type_id)');
        $this->addSql('CREATE INDEX IDX_8BF21CDE6BF700BD ON property (status_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE property DROP FOREIGN KEY FK_8BF21CDEC54C8C93');
        $this->addSql('ALTER TABLE property DROP FOREIGN KEY FK_8BF21CDE6BF700BD');
        $this->addSql('DROP INDEX IDX_8BF21CDEC54C8C93 ON property');
        $this->addSql('DROP INDEX IDX_8BF21CDE6BF700BD ON property');
        $this->addSql('ALTER TABLE property DROP type_id, DROP status_id, DROP price');
    }
}
