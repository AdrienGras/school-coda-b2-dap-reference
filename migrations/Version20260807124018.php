<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260807124018 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE city (created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, id UUID NOT NULL, name VARCHAR(255) NOT NULL, created_by_id UUID DEFAULT NULL, updated_by_id UUID DEFAULT NULL, deleted_by_id UUID DEFAULT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE INDEX IDX_2D5B0234B03A8386 ON city (created_by_id)');
        $this->addSql('CREATE INDEX IDX_2D5B0234896DBBDE ON city (updated_by_id)');
        $this->addSql('CREATE INDEX IDX_2D5B0234C76F1F52 ON city (deleted_by_id)');
        $this->addSql('ALTER TABLE city ADD CONSTRAINT FK_2D5B0234B03A8386 FOREIGN KEY (created_by_id) REFERENCES "user" (id) NOT DEFERRABLE');
        $this->addSql('ALTER TABLE city ADD CONSTRAINT FK_2D5B0234896DBBDE FOREIGN KEY (updated_by_id) REFERENCES "user" (id) NOT DEFERRABLE');
        $this->addSql('ALTER TABLE city ADD CONSTRAINT FK_2D5B0234C76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES "user" (id) NOT DEFERRABLE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE city DROP CONSTRAINT FK_2D5B0234B03A8386');
        $this->addSql('ALTER TABLE city DROP CONSTRAINT FK_2D5B0234896DBBDE');
        $this->addSql('ALTER TABLE city DROP CONSTRAINT FK_2D5B0234C76F1F52');
        $this->addSql('DROP TABLE city');
    }
}
