<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260407093612 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__lieu AS SELECT id, titre, description, adresse, latitude, longitude, slug, created_at, updated_at, est_valide, nombre_vues, categorie_id, user_id FROM lieu');
        $this->addSql('DROP TABLE lieu');
        $this->addSql('CREATE TABLE lieu (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, description CLOB NOT NULL, adresse VARCHAR(255) NOT NULL, latitude DOUBLE PRECISION NOT NULL, longitude DOUBLE PRECISION NOT NULL, slug VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, est_valide BOOLEAN NOT NULL, nombre_vues INTEGER NOT NULL, categorie_id INTEGER NOT NULL, user_id INTEGER NOT NULL, CONSTRAINT FK_2F577D59BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_2F577D59A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO lieu (id, titre, description, adresse, latitude, longitude, slug, created_at, updated_at, est_valide, nombre_vues, categorie_id, user_id) SELECT id, titre, description, adresse, latitude, longitude, slug, created_at, updated_at, est_valide, nombre_vues, categorie_id, user_id FROM __temp__lieu');
        $this->addSql('DROP TABLE __temp__lieu');
        $this->addSql('CREATE INDEX IDX_2F577D59A76ED395 ON lieu (user_id)');
        $this->addSql('CREATE INDEX IDX_2F577D59BCF5E72D ON lieu (categorie_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__lieu AS SELECT id, titre, description, adresse, latitude, longitude, slug, created_at, updated_at, est_valide, nombre_vues, categorie_id, user_id FROM lieu');
        $this->addSql('DROP TABLE lieu');
        $this->addSql('CREATE TABLE lieu (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, description CLOB NOT NULL, adresse VARCHAR(255) NOT NULL, latitude DOUBLE PRECISION NOT NULL, longitude DOUBLE PRECISION NOT NULL, slug VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, est_valide BOOLEAN NOT NULL, nombre_vues INTEGER NOT NULL, categorie_id INTEGER NOT NULL, user_id INTEGER NOT NULL, CONSTRAINT FK_2F577D59BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_2F577D59A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO lieu (id, titre, description, adresse, latitude, longitude, slug, created_at, updated_at, est_valide, nombre_vues, categorie_id, user_id) SELECT id, titre, description, adresse, latitude, longitude, slug, created_at, updated_at, est_valide, nombre_vues, categorie_id, user_id FROM __temp__lieu');
        $this->addSql('DROP TABLE __temp__lieu');
        $this->addSql('CREATE INDEX IDX_2F577D59BCF5E72D ON lieu (categorie_id)');
        $this->addSql('CREATE INDEX IDX_2F577D59A76ED395 ON lieu (user_id)');
    }
}
