<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Migration:
 * adding roles,
 * modify email colum name
 * modify password varchar length
 */
final class Version20230510083145 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user ADD roles JSON NOT NULL, ADD password VARCHAR(15) NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE mail email VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE password password VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user DROP roles, DROP password');
        $this->addSql('ALTER TABLE user CHANGE email mail VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE password password VARCHAR(15) NOT NULL');
    }
}
