<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200506185228 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TEMPORARY TABLE __temp__category AS SELECT id, parent_category FROM category');
        $this->addSql('DROP TABLE category');
        $this->addSql('CREATE TABLE category (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name_id INTEGER NOT NULL, parent_category INTEGER DEFAULT NULL, CONSTRAINT FK_64C19C171179CD6 FOREIGN KEY (name_id) REFERENCES text (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO category (id, parent_category) SELECT id, parent_category FROM __temp__category');
        $this->addSql('DROP TABLE __temp__category');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_64C19C171179CD6 ON category (name_id)');
        $this->addSql('DROP INDEX IDX_D34A04AD12469DE2');
        $this->addSql('DROP INDEX IDX_D34A04ADF8BD700D');
        $this->addSql('CREATE TEMPORARY TABLE __temp__product AS SELECT id, category_id, unit_id, name, price FROM product');
        $this->addSql('DROP TABLE product');
        $this->addSql('CREATE TABLE product (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, category_id INTEGER DEFAULT NULL, unit_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY, price DOUBLE PRECISION DEFAULT NULL, CONSTRAINT FK_D34A04AD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D34A04ADF8BD700D FOREIGN KEY (unit_id) REFERENCES unit (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO product (id, category_id, unit_id, name, price) SELECT id, category_id, unit_id, name, price FROM __temp__product');
        $this->addSql('DROP TABLE __temp__product');
        $this->addSql('CREATE INDEX IDX_D34A04AD12469DE2 ON product (category_id)');
        $this->addSql('CREATE INDEX IDX_D34A04ADF8BD700D ON product (unit_id)');
        $this->addSql('DROP INDEX IDX_B469456F82F1BAF4');
        $this->addSql('DROP INDEX IDX_B469456F698D3548');
        $this->addSql('CREATE TEMPORARY TABLE __temp__translation AS SELECT id, text_id, language_id, translation FROM translation');
        $this->addSql('DROP TABLE translation');
        $this->addSql('CREATE TABLE translation (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, text_id INTEGER DEFAULT NULL, language_id INTEGER NOT NULL, translation VARCHAR(255) NOT NULL COLLATE BINARY, CONSTRAINT FK_B469456F698D3548 FOREIGN KEY (text_id) REFERENCES text (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_B469456F82F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO translation (id, text_id, language_id, translation) SELECT id, text_id, language_id, translation FROM __temp__translation');
        $this->addSql('DROP TABLE __temp__translation');
        $this->addSql('CREATE INDEX IDX_B469456F82F1BAF4 ON translation (language_id)');
        $this->addSql('CREATE INDEX IDX_B469456F698D3548 ON translation (text_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX UNIQ_64C19C171179CD6');
        $this->addSql('CREATE TEMPORARY TABLE __temp__category AS SELECT id, parent_category FROM category');
        $this->addSql('DROP TABLE category');
        $this->addSql('CREATE TABLE category (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, parent_category INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY)');
        $this->addSql('INSERT INTO category (id, parent_category) SELECT id, parent_category FROM __temp__category');
        $this->addSql('DROP TABLE __temp__category');
        $this->addSql('DROP INDEX IDX_D34A04AD12469DE2');
        $this->addSql('DROP INDEX IDX_D34A04ADF8BD700D');
        $this->addSql('CREATE TEMPORARY TABLE __temp__product AS SELECT id, category_id, unit_id, name, price FROM product');
        $this->addSql('DROP TABLE product');
        $this->addSql('CREATE TABLE product (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, category_id INTEGER DEFAULT NULL, unit_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, price DOUBLE PRECISION DEFAULT NULL)');
        $this->addSql('INSERT INTO product (id, category_id, unit_id, name, price) SELECT id, category_id, unit_id, name, price FROM __temp__product');
        $this->addSql('DROP TABLE __temp__product');
        $this->addSql('CREATE INDEX IDX_D34A04AD12469DE2 ON product (category_id)');
        $this->addSql('CREATE INDEX IDX_D34A04ADF8BD700D ON product (unit_id)');
        $this->addSql('DROP INDEX IDX_B469456F698D3548');
        $this->addSql('DROP INDEX IDX_B469456F82F1BAF4');
        $this->addSql('CREATE TEMPORARY TABLE __temp__translation AS SELECT id, text_id, language_id, translation FROM translation');
        $this->addSql('DROP TABLE translation');
        $this->addSql('CREATE TABLE translation (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, text_id INTEGER DEFAULT NULL, language_id INTEGER NOT NULL, translation VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO translation (id, text_id, language_id, translation) SELECT id, text_id, language_id, translation FROM __temp__translation');
        $this->addSql('DROP TABLE __temp__translation');
        $this->addSql('CREATE INDEX IDX_B469456F698D3548 ON translation (text_id)');
        $this->addSql('CREATE INDEX IDX_B469456F82F1BAF4 ON translation (language_id)');
    }
}
