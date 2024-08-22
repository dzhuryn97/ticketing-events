<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240720141217 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id UUID NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN category.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE event (id UUID NOT NULL, category_id UUID DEFAULT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, location VARCHAR(255) NOT NULL, starts_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, ends_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3BAE0AA712469DE2 ON event (category_id)');
        $this->addSql('COMMENT ON COLUMN event.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN event.category_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN event.starts_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN event.ends_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE ticket_type (id UUID NOT NULL, event_id UUID DEFAULT NULL, name VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, currency VARCHAR(255) NOT NULL, quantity INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_BE05421171F7E88B ON ticket_type (event_id)');
        $this->addSql('COMMENT ON COLUMN ticket_type.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN ticket_type.event_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA712469DE2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ticket_type ADD CONSTRAINT FK_BE05421171F7E88B FOREIGN KEY (event_id) REFERENCES event (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event DROP CONSTRAINT FK_3BAE0AA712469DE2');
        $this->addSql('ALTER TABLE ticket_type DROP CONSTRAINT FK_BE05421171F7E88B');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE ticket_type');
    }
}
