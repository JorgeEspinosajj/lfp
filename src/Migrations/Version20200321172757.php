<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200321172757 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE entrenador (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, equipo_id INTEGER DEFAULT NULL, nombre VARCHAR(255) NOT NULL, foto VARCHAR(255) NOT NULL, nacionalidad VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FD19603B23BFBED ON entrenador (equipo_id)');
        $this->addSql('CREATE TABLE equipo (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nombre VARCHAR(150) NOT NULL, escudo VARCHAR(255) NOT NULL, descripcion CLOB DEFAULT NULL)');
        $this->addSql('CREATE TABLE estadio (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, equipo_id INTEGER NOT NULL, nombre VARCHAR(255) NOT NULL, foto VARCHAR(255) NOT NULL, capacidad INTEGER NOT NULL, fecha_ing DATE NOT NULL, ciudad VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6070DAE123BFBED ON estadio (equipo_id)');
        $this->addSql('CREATE TABLE jugador (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, equipo_id INTEGER NOT NULL, nombre VARCHAR(200) NOT NULL, foto VARCHAR(255) NOT NULL, fecha_nac DATE NOT NULL, nacionalidad VARCHAR(150) NOT NULL, dorsal INTEGER NOT NULL)');
        $this->addSql('CREATE INDEX IDX_527D6F1823BFBED ON jugador (equipo_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE entrenador');
        $this->addSql('DROP TABLE equipo');
        $this->addSql('DROP TABLE estadio');
        $this->addSql('DROP TABLE jugador');
    }
}
