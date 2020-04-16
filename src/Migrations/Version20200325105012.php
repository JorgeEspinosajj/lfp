<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200325105012 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX UNIQ_FD19603B23BFBED');
        $this->addSql('CREATE TEMPORARY TABLE __temp__entrenador AS SELECT id, equipo_id, nombre, foto, nacionalidad FROM entrenador');
        $this->addSql('DROP TABLE entrenador');
        $this->addSql('CREATE TABLE entrenador (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, equipo_id INTEGER DEFAULT NULL, nombre VARCHAR(255) NOT NULL COLLATE BINARY, foto VARCHAR(255) NOT NULL COLLATE BINARY, nacionalidad VARCHAR(255) NOT NULL COLLATE BINARY, CONSTRAINT FK_FD19603B23BFBED FOREIGN KEY (equipo_id) REFERENCES equipo (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO entrenador (id, equipo_id, nombre, foto, nacionalidad) SELECT id, equipo_id, nombre, foto, nacionalidad FROM __temp__entrenador');
        $this->addSql('DROP TABLE __temp__entrenador');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FD19603B23BFBED ON entrenador (equipo_id)');
        $this->addSql('ALTER TABLE equipo ADD COLUMN puntos INTEGER DEFAULT NULL');
        $this->addSql('DROP INDEX UNIQ_6070DAE123BFBED');
        $this->addSql('CREATE TEMPORARY TABLE __temp__estadio AS SELECT id, equipo_id, nombre, foto, capacidad, fecha_ing, ciudad FROM estadio');
        $this->addSql('DROP TABLE estadio');
        $this->addSql('CREATE TABLE estadio (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, equipo_id INTEGER NOT NULL, nombre VARCHAR(255) NOT NULL COLLATE BINARY, foto VARCHAR(255) NOT NULL COLLATE BINARY, capacidad INTEGER NOT NULL, fecha_ing DATE NOT NULL, ciudad VARCHAR(255) NOT NULL COLLATE BINARY, CONSTRAINT FK_6070DAE123BFBED FOREIGN KEY (equipo_id) REFERENCES equipo (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO estadio (id, equipo_id, nombre, foto, capacidad, fecha_ing, ciudad) SELECT id, equipo_id, nombre, foto, capacidad, fecha_ing, ciudad FROM __temp__estadio');
        $this->addSql('DROP TABLE __temp__estadio');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6070DAE123BFBED ON estadio (equipo_id)');
        $this->addSql('DROP INDEX IDX_527D6F1823BFBED');
        $this->addSql('CREATE TEMPORARY TABLE __temp__jugador AS SELECT id, equipo_id, nombre, foto, fecha_nac, nacionalidad, dorsal FROM jugador');
        $this->addSql('DROP TABLE jugador');
        $this->addSql('CREATE TABLE jugador (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, equipo_id INTEGER NOT NULL, nombre VARCHAR(200) NOT NULL COLLATE BINARY, foto VARCHAR(255) NOT NULL COLLATE BINARY, fecha_nac DATE NOT NULL, nacionalidad VARCHAR(150) NOT NULL COLLATE BINARY, dorsal INTEGER NOT NULL, CONSTRAINT FK_527D6F1823BFBED FOREIGN KEY (equipo_id) REFERENCES equipo (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO jugador (id, equipo_id, nombre, foto, fecha_nac, nacionalidad, dorsal) SELECT id, equipo_id, nombre, foto, fecha_nac, nacionalidad, dorsal FROM __temp__jugador');
        $this->addSql('DROP TABLE __temp__jugador');
        $this->addSql('CREATE INDEX IDX_527D6F1823BFBED ON jugador (equipo_id)');
        $this->addSql('DROP INDEX IDX_8C926FF688774E73');
        $this->addSql('DROP INDEX IDX_8C926FF68C243011');
        $this->addSql('CREATE TEMPORARY TABLE __temp__partidos AS SELECT id, equipo_local_id, equipo_visitante_id, goles_local, goles_visitante, resultado, resultado_v FROM partidos');
        $this->addSql('DROP TABLE partidos');
        $this->addSql('CREATE TABLE partidos (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, equipo_local_id INTEGER NOT NULL, equipo_visitante_id INTEGER NOT NULL, goles_local INTEGER DEFAULT NULL, goles_visitante INTEGER DEFAULT NULL, resultado VARCHAR(200) DEFAULT NULL COLLATE BINARY, resultado_v VARCHAR(255) DEFAULT NULL COLLATE BINARY, CONSTRAINT FK_8C926FF688774E73 FOREIGN KEY (equipo_local_id) REFERENCES equipo (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_8C926FF68C243011 FOREIGN KEY (equipo_visitante_id) REFERENCES equipo (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO partidos (id, equipo_local_id, equipo_visitante_id, goles_local, goles_visitante, resultado, resultado_v) SELECT id, equipo_local_id, equipo_visitante_id, goles_local, goles_visitante, resultado, resultado_v FROM __temp__partidos');
        $this->addSql('DROP TABLE __temp__partidos');
        $this->addSql('CREATE INDEX IDX_8C926FF688774E73 ON partidos (equipo_local_id)');
        $this->addSql('CREATE INDEX IDX_8C926FF68C243011 ON partidos (equipo_visitante_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX UNIQ_FD19603B23BFBED');
        $this->addSql('CREATE TEMPORARY TABLE __temp__entrenador AS SELECT id, equipo_id, nombre, foto, nacionalidad FROM entrenador');
        $this->addSql('DROP TABLE entrenador');
        $this->addSql('CREATE TABLE entrenador (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, equipo_id INTEGER DEFAULT NULL, nombre VARCHAR(255) NOT NULL, foto VARCHAR(255) NOT NULL, nacionalidad VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO entrenador (id, equipo_id, nombre, foto, nacionalidad) SELECT id, equipo_id, nombre, foto, nacionalidad FROM __temp__entrenador');
        $this->addSql('DROP TABLE __temp__entrenador');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FD19603B23BFBED ON entrenador (equipo_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__equipo AS SELECT id, nombre, escudo, descripcion FROM equipo');
        $this->addSql('DROP TABLE equipo');
        $this->addSql('CREATE TABLE equipo (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nombre VARCHAR(150) NOT NULL, escudo VARCHAR(255) NOT NULL, descripcion CLOB DEFAULT NULL)');
        $this->addSql('INSERT INTO equipo (id, nombre, escudo, descripcion) SELECT id, nombre, escudo, descripcion FROM __temp__equipo');
        $this->addSql('DROP TABLE __temp__equipo');
        $this->addSql('DROP INDEX UNIQ_6070DAE123BFBED');
        $this->addSql('CREATE TEMPORARY TABLE __temp__estadio AS SELECT id, equipo_id, nombre, foto, capacidad, fecha_ing, ciudad FROM estadio');
        $this->addSql('DROP TABLE estadio');
        $this->addSql('CREATE TABLE estadio (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, equipo_id INTEGER NOT NULL, nombre VARCHAR(255) NOT NULL, foto VARCHAR(255) NOT NULL, capacidad INTEGER NOT NULL, fecha_ing DATE NOT NULL, ciudad VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO estadio (id, equipo_id, nombre, foto, capacidad, fecha_ing, ciudad) SELECT id, equipo_id, nombre, foto, capacidad, fecha_ing, ciudad FROM __temp__estadio');
        $this->addSql('DROP TABLE __temp__estadio');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6070DAE123BFBED ON estadio (equipo_id)');
        $this->addSql('DROP INDEX IDX_527D6F1823BFBED');
        $this->addSql('CREATE TEMPORARY TABLE __temp__jugador AS SELECT id, equipo_id, nombre, foto, fecha_nac, nacionalidad, dorsal FROM jugador');
        $this->addSql('DROP TABLE jugador');
        $this->addSql('CREATE TABLE jugador (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, equipo_id INTEGER NOT NULL, nombre VARCHAR(200) NOT NULL, foto VARCHAR(255) NOT NULL, fecha_nac DATE NOT NULL, nacionalidad VARCHAR(150) NOT NULL, dorsal INTEGER NOT NULL)');
        $this->addSql('INSERT INTO jugador (id, equipo_id, nombre, foto, fecha_nac, nacionalidad, dorsal) SELECT id, equipo_id, nombre, foto, fecha_nac, nacionalidad, dorsal FROM __temp__jugador');
        $this->addSql('DROP TABLE __temp__jugador');
        $this->addSql('CREATE INDEX IDX_527D6F1823BFBED ON jugador (equipo_id)');
        $this->addSql('DROP INDEX IDX_8C926FF688774E73');
        $this->addSql('DROP INDEX IDX_8C926FF68C243011');
        $this->addSql('CREATE TEMPORARY TABLE __temp__partidos AS SELECT id, equipo_local_id, equipo_visitante_id, goles_local, goles_visitante, resultado, resultado_v FROM partidos');
        $this->addSql('DROP TABLE partidos');
        $this->addSql('CREATE TABLE partidos (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, equipo_local_id INTEGER NOT NULL, equipo_visitante_id INTEGER NOT NULL, goles_local INTEGER DEFAULT NULL, goles_visitante INTEGER DEFAULT NULL, resultado VARCHAR(200) DEFAULT NULL, resultado_v VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO partidos (id, equipo_local_id, equipo_visitante_id, goles_local, goles_visitante, resultado, resultado_v) SELECT id, equipo_local_id, equipo_visitante_id, goles_local, goles_visitante, resultado, resultado_v FROM __temp__partidos');
        $this->addSql('DROP TABLE __temp__partidos');
        $this->addSql('CREATE INDEX IDX_8C926FF688774E73 ON partidos (equipo_local_id)');
        $this->addSql('CREATE INDEX IDX_8C926FF68C243011 ON partidos (equipo_visitante_id)');
    }
}
