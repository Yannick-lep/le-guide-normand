<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260407092906 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__categorie AS SELECT id, nom, description, slug, icone FROM categorie');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('CREATE TABLE categorie (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, description CLOB DEFAULT NULL, slug VARCHAR(150) NOT NULL, icone VARCHAR(50) NOT NULL)');
        $this->addSql('INSERT INTO categorie (id, nom, description, slug, icone) SELECT id, nom, description, slug, icone FROM __temp__categorie');
        $this->addSql('DROP TABLE __temp__categorie');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__categorie AS SELECT id, nom, description, slug, icone FROM categorie');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('CREATE TABLE categorie (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, description CLOB NOT NULL, slug VARCHAR(150) NOT NULL, icone VARCHAR(50) NOT NULL)');
        $this->addSql('INSERT INTO categorie (id, nom, description, slug, icone) SELECT id, nom, description, slug, icone FROM __temp__categorie');
        $this->addSql('DROP TABLE __temp__categorie');
    }
}
