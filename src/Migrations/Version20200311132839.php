<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200311132839 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE field_type (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE event ADD description LONGTEXT NOT NULL, CHANGE user_id user_id INT DEFAULT NULL, CHANGE image image VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE field ADD event_id INT DEFAULT NULL, ADD type_id INT DEFAULT NULL, DROP type');
        $this->addSql('ALTER TABLE field ADD CONSTRAINT FK_5BF5455871F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE field ADD CONSTRAINT FK_5BF54558C54C8C93 FOREIGN KEY (type_id) REFERENCES field_type (id)');
        $this->addSql('CREATE INDEX IDX_5BF5455871F7E88B ON field (event_id)');
        $this->addSql('CREATE INDEX IDX_5BF54558C54C8C93 ON field (type_id)');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE field DROP FOREIGN KEY FK_5BF54558C54C8C93');
        $this->addSql('DROP TABLE field_type');
        $this->addSql('ALTER TABLE event DROP description, CHANGE user_id user_id INT DEFAULT NULL, CHANGE image image VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE field DROP FOREIGN KEY FK_5BF5455871F7E88B');
        $this->addSql('DROP INDEX IDX_5BF5455871F7E88B ON field');
        $this->addSql('DROP INDEX IDX_5BF54558C54C8C93 ON field');
        $this->addSql('ALTER TABLE field ADD type VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP event_id, DROP type_id');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
    }
}
