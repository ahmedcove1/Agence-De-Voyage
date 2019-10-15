<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181019094712 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE programmation_circuit (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, circuit_id INTEGER NOT NULL, date_depart DATETIME NOT NULL, nombre_personnes SMALLINT NOT NULL, prix SMALLINT NOT NULL)');
        $this->addSql('CREATE INDEX IDX_89370F97CF2182C8 ON programmation_circuit (circuit_id)');
        $this->addSql('CREATE TABLE etape (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, circuit_id INTEGER NOT NULL, numero_etape SMALLINT NOT NULL, ville_etape VARCHAR(255) NOT NULL, nombre_jours SMALLINT NOT NULL)');
        $this->addSql('CREATE INDEX IDX_285F75DDCF2182C8 ON etape (circuit_id)');
        $this->addSql('CREATE TABLE circuit (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, description CLOB NOT NULL, pays_depart VARCHAR(255) DEFAULT NULL, ville_depart VARCHAR(255) DEFAULT NULL, ville_arrivee VARCHAR(255) DEFAULT NULL, duree_circuit SMALLINT DEFAULT NULL)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE programmation_circuit');
        $this->addSql('DROP TABLE etape');
        $this->addSql('DROP TABLE circuit');
    }
}
