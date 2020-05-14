<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200506183433 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE language (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, language VARCHAR(5) NOT NULL)');
        $this->addSql('CREATE TABLE text (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, description VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE translation (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, text_id INTEGER DEFAULT NULL, language_id INTEGER NOT NULL, translation VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE INDEX IDX_B469456F698D3548 ON translation (text_id)');
        $this->addSql('CREATE INDEX IDX_B469456F82F1BAF4 ON translation (language_id)');
        $this->addSql('DROP INDEX IDX_D34A04ADF8BD700D');
        $this->addSql('DROP INDEX IDX_D34A04AD12469DE2');
        $this->addSql('CREATE TEMPORARY TABLE __temp__product AS SELECT id, category_id, unit_id, name, price FROM product');
        $this->addSql('DROP TABLE product');
        $this->addSql('CREATE TABLE product (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, category_id INTEGER DEFAULT NULL, unit_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY, price DOUBLE PRECISION DEFAULT NULL, CONSTRAINT FK_D34A04AD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D34A04ADF8BD700D FOREIGN KEY (unit_id) REFERENCES unit (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO product (id, category_id, unit_id, name, price) SELECT id, category_id, unit_id, name, price FROM __temp__product');
        $this->addSql('DROP TABLE __temp__product');
        $this->addSql('CREATE INDEX IDX_D34A04ADF8BD700D ON product (unit_id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD12469DE2 ON product (category_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE language');
        $this->addSql('DROP TABLE text');
        $this->addSql('DROP TABLE translation');
        $this->addSql('DROP INDEX IDX_D34A04AD12469DE2');
        $this->addSql('DROP INDEX IDX_D34A04ADF8BD700D');
        $this->addSql('CREATE TEMPORARY TABLE __temp__product AS SELECT id, category_id, unit_id, name, price FROM product');
        $this->addSql('DROP TABLE product');
        $this->addSql('CREATE TABLE product (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, category_id INTEGER DEFAULT NULL, unit_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, price DOUBLE PRECISION DEFAULT NULL)');
        $this->addSql('INSERT INTO product (id, category_id, unit_id, name, price) SELECT id, category_id, unit_id, name, price FROM __temp__product');
        $this->addSql('DROP TABLE __temp__product');
        $this->addSql('CREATE INDEX IDX_D34A04AD12469DE2 ON product (category_id)');
        $this->addSql('CREATE INDEX IDX_D34A04ADF8BD700D ON product (unit_id)');
    }
}
