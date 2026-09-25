<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260925110027 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ticket (created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, id UUID NOT NULL, price INT NOT NULL, created_by_id UUID DEFAULT NULL, updated_by_id UUID DEFAULT NULL, deleted_by_id UUID DEFAULT NULL, trip_id UUID NOT NULL, cart_id UUID NOT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE INDEX IDX_97A0ADA3B03A8386 ON ticket (created_by_id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA3896DBBDE ON ticket (updated_by_id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA3C76F1F52 ON ticket (deleted_by_id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA3A5BC2E0E ON ticket (trip_id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA31AD5CDBF ON ticket (cart_id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3B03A8386 FOREIGN KEY (created_by_id) REFERENCES "user" (id) NOT DEFERRABLE');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3896DBBDE FOREIGN KEY (updated_by_id) REFERENCES "user" (id) NOT DEFERRABLE');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3C76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES "user" (id) NOT DEFERRABLE');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3A5BC2E0E FOREIGN KEY (trip_id) REFERENCES trip (id) NOT DEFERRABLE');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA31AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id) NOT DEFERRABLE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ticket DROP CONSTRAINT FK_97A0ADA3B03A8386');
        $this->addSql('ALTER TABLE ticket DROP CONSTRAINT FK_97A0ADA3896DBBDE');
        $this->addSql('ALTER TABLE ticket DROP CONSTRAINT FK_97A0ADA3C76F1F52');
        $this->addSql('ALTER TABLE ticket DROP CONSTRAINT FK_97A0ADA3A5BC2E0E');
        $this->addSql('ALTER TABLE ticket DROP CONSTRAINT FK_97A0ADA31AD5CDBF');
        $this->addSql('DROP TABLE ticket');
    }
}
