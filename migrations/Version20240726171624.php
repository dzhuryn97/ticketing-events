<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240726171624 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE inbox_messages (inbox_message_id UUID NOT NULL, content TEXT NOT NULL, occurred_on TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_on TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, rejected_on TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, processed_on TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(inbox_message_id))');
        $this->addSql('COMMENT ON COLUMN inbox_messages.inbox_message_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN inbox_messages.occurred_on IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN inbox_messages.delivered_on IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN inbox_messages.rejected_on IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN inbox_messages.processed_on IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE inbox_messages');
    }
}
