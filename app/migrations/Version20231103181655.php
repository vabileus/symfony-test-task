<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20231103181655 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Hashed data Entity migration';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE hashed_data (id UUID NOT NULL, data TEXT NOT NULL, hashed_data TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN hashed_data.id IS \'(DC2Type:uuid)\'');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE hashed_data');
    }
}
