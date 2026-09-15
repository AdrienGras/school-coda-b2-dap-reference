<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260914133152 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cart (created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, id UUID NOT NULL, status VARCHAR(255) NOT NULL, created_by_id UUID DEFAULT NULL, updated_by_id UUID DEFAULT NULL, deleted_by_id UUID DEFAULT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE INDEX IDX_BA388B7B03A8386 ON cart (created_by_id)');
        $this->addSql('CREATE INDEX IDX_BA388B7896DBBDE ON cart (updated_by_id)');
        $this->addSql('CREATE INDEX IDX_BA388B7C76F1F52 ON cart (deleted_by_id)');
        $this->addSql('CREATE TABLE cart_item (created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, id UUID NOT NULL, passengers INT NOT NULL, created_by_id UUID DEFAULT NULL, updated_by_id UUID DEFAULT NULL, deleted_by_id UUID DEFAULT NULL, cart_id UUID NOT NULL, trip_id UUID NOT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE INDEX IDX_F0FE2527B03A8386 ON cart_item (created_by_id)');
        $this->addSql('CREATE INDEX IDX_F0FE2527896DBBDE ON cart_item (updated_by_id)');
        $this->addSql('CREATE INDEX IDX_F0FE2527C76F1F52 ON cart_item (deleted_by_id)');
        $this->addSql('CREATE INDEX IDX_F0FE25271AD5CDBF ON cart_item (cart_id)');
        $this->addSql('CREATE INDEX IDX_F0FE2527A5BC2E0E ON cart_item (trip_id)');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT FK_BA388B7B03A8386 FOREIGN KEY (created_by_id) REFERENCES "user" (id) NOT DEFERRABLE');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT FK_BA388B7896DBBDE FOREIGN KEY (updated_by_id) REFERENCES "user" (id) NOT DEFERRABLE');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT FK_BA388B7C76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES "user" (id) NOT DEFERRABLE');
        $this->addSql('ALTER TABLE cart_item ADD CONSTRAINT FK_F0FE2527B03A8386 FOREIGN KEY (created_by_id) REFERENCES "user" (id) NOT DEFERRABLE');
        $this->addSql('ALTER TABLE cart_item ADD CONSTRAINT FK_F0FE2527896DBBDE FOREIGN KEY (updated_by_id) REFERENCES "user" (id) NOT DEFERRABLE');
        $this->addSql('ALTER TABLE cart_item ADD CONSTRAINT FK_F0FE2527C76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES "user" (id) NOT DEFERRABLE');
        $this->addSql('ALTER TABLE cart_item ADD CONSTRAINT FK_F0FE25271AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id) NOT DEFERRABLE');
        $this->addSql('ALTER TABLE cart_item ADD CONSTRAINT FK_F0FE2527A5BC2E0E FOREIGN KEY (trip_id) REFERENCES trip (id) NOT DEFERRABLE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cart DROP CONSTRAINT FK_BA388B7B03A8386');
        $this->addSql('ALTER TABLE cart DROP CONSTRAINT FK_BA388B7896DBBDE');
        $this->addSql('ALTER TABLE cart DROP CONSTRAINT FK_BA388B7C76F1F52');
        $this->addSql('ALTER TABLE cart_item DROP CONSTRAINT FK_F0FE2527B03A8386');
        $this->addSql('ALTER TABLE cart_item DROP CONSTRAINT FK_F0FE2527896DBBDE');
        $this->addSql('ALTER TABLE cart_item DROP CONSTRAINT FK_F0FE2527C76F1F52');
        $this->addSql('ALTER TABLE cart_item DROP CONSTRAINT FK_F0FE25271AD5CDBF');
        $this->addSql('ALTER TABLE cart_item DROP CONSTRAINT FK_F0FE2527A5BC2E0E');
        $this->addSql('DROP TABLE cart');
        $this->addSql('DROP TABLE cart_item');
    }
}
