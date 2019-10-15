<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181126195428 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE reservation (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, telephone VARCHAR(50) NOT NULL, email VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE reservation_programmation_circuit (reservation_id INTEGER NOT NULL, programmation_circuit_id INTEGER NOT NULL, PRIMARY KEY(reservation_id, programmation_circuit_id))');
        $this->addSql('CREATE INDEX IDX_43AE8F34B83297E7 ON reservation_programmation_circuit (reservation_id)');
        $this->addSql('CREATE INDEX IDX_43AE8F34A138D20C ON reservation_programmation_circuit (programmation_circuit_id)');
        $this->addSql('DROP INDEX IDX_285F75DDCF2182C8');
        $this->addSql('CREATE TEMPORARY TABLE __temp__etape AS SELECT id, circuit_id, numero_etape, ville_etape, nombre_jours, url_image FROM etape');
        $this->addSql('DROP TABLE etape');
        $this->addSql('CREATE TABLE etape (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, circuit_id INTEGER NOT NULL, numero_etape SMALLINT NOT NULL, ville_etape VARCHAR(255) NOT NULL COLLATE BINARY, nombre_jours SMALLINT NOT NULL, url_image VARCHAR(255) DEFAULT NULL COLLATE BINARY, CONSTRAINT FK_285F75DDCF2182C8 FOREIGN KEY (circuit_id) REFERENCES circuit (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO etape (id, circuit_id, numero_etape, ville_etape, nombre_jours, url_image) SELECT id, circuit_id, numero_etape, ville_etape, nombre_jours, url_image FROM __temp__etape');
        $this->addSql('DROP TABLE __temp__etape');
        $this->addSql('CREATE INDEX IDX_285F75DDCF2182C8 ON etape (circuit_id)');
        $this->addSql('DROP INDEX IDX_89370F97CF2182C8');
        $this->addSql('CREATE TEMPORARY TABLE __temp__programmation_circuit AS SELECT id, circuit_id, date_depart, nombre_personnes, prix FROM programmation_circuit');
        $this->addSql('DROP TABLE programmation_circuit');
        $this->addSql('CREATE TABLE programmation_circuit (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, circuit_id INTEGER NOT NULL, date_depart DATETIME NOT NULL, nombre_personnes SMALLINT NOT NULL, prix SMALLINT NOT NULL, CONSTRAINT FK_89370F97CF2182C8 FOREIGN KEY (circuit_id) REFERENCES circuit (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO programmation_circuit (id, circuit_id, date_depart, nombre_personnes, prix) SELECT id, circuit_id, date_depart, nombre_personnes, prix FROM __temp__programmation_circuit');
        $this->addSql('DROP TABLE __temp__programmation_circuit');
        $this->addSql('CREATE INDEX IDX_89370F97CF2182C8 ON programmation_circuit (circuit_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE reservation_programmation_circuit');
        $this->addSql('DROP INDEX IDX_285F75DDCF2182C8');
        $this->addSql('CREATE TEMPORARY TABLE __temp__etape AS SELECT id, circuit_id, numero_etape, ville_etape, nombre_jours, url_image FROM etape');
        $this->addSql('DROP TABLE etape');
        $this->addSql('CREATE TABLE etape (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, circuit_id INTEGER NOT NULL, numero_etape SMALLINT NOT NULL, ville_etape VARCHAR(255) NOT NULL, nombre_jours SMALLINT NOT NULL, url_image VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO etape (id, circuit_id, numero_etape, ville_etape, nombre_jours, url_image) SELECT id, circuit_id, numero_etape, ville_etape, nombre_jours, url_image FROM __temp__etape');
        $this->addSql('DROP TABLE __temp__etape');
        $this->addSql('CREATE INDEX IDX_285F75DDCF2182C8 ON etape (circuit_id)');
        $this->addSql('DROP INDEX IDX_89370F97CF2182C8');
        $this->addSql('CREATE TEMPORARY TABLE __temp__programmation_circuit AS SELECT id, circuit_id, date_depart, nombre_personnes, prix FROM programmation_circuit');
        $this->addSql('DROP TABLE programmation_circuit');
        $this->addSql('CREATE TABLE programmation_circuit (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, circuit_id INTEGER NOT NULL, date_depart DATETIME NOT NULL, nombre_personnes SMALLINT NOT NULL, prix SMALLINT NOT NULL)');
        $this->addSql('INSERT INTO programmation_circuit (id, circuit_id, date_depart, nombre_personnes, prix) SELECT id, circuit_id, date_depart, nombre_personnes, prix FROM __temp__programmation_circuit');
        $this->addSql('DROP TABLE __temp__programmation_circuit');
        $this->addSql('CREATE INDEX IDX_89370F97CF2182C8 ON programmation_circuit (circuit_id)');
    }
}
