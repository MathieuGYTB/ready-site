<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220825124322 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bill (id INT AUTO_INCREMENT NOT NULL, name_id INT NOT NULL, firstname_id INT NOT NULL, email_id INT NOT NULL, description VARCHAR(255) NOT NULL, quantity INT NOT NULL, price NUMERIC(4, 2) NOT NULL, money VARCHAR(5) NOT NULL, UNIQUE INDEX UNIQ_7A2119E371179CD6 (name_id), UNIQUE INDEX UNIQ_7A2119E368D0D14D (firstname_id), UNIQUE INDEX UNIQ_7A2119E3A832C1C9 (email_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bill ADD CONSTRAINT FK_7A2119E371179CD6 FOREIGN KEY (name_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE bill ADD CONSTRAINT FK_7A2119E368D0D14D FOREIGN KEY (firstname_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE bill ADD CONSTRAINT FK_7A2119E3A832C1C9 FOREIGN KEY (email_id) REFERENCES user (id)');
        $this->addSql('DROP TABLE facture');
        $this->addSql('DROP INDEX `unique` ON user');
        $this->addSql('ALTER TABLE user DROP facture, CHANGE roles roles JSON NOT NULL, CHANGE password password VARCHAR(255) NOT NULL, CHANGE is_verified is_verified TINYINT(1) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE facture (numéro INT AUTO_INCREMENT NOT NULL, description CHAR(4) CHARACTER SET utf8 DEFAULT \'Pack\' NOT NULL COLLATE `utf8_general_ci`, quantité INT DEFAULT 1 NOT NULL, prix NUMERIC(4, 2) DEFAULT \'29.99\' NOT NULL, monnaie CHAR(5) CHARACTER SET utf8 DEFAULT \'euros\' NOT NULL COLLATE `utf8_general_ci`, PRIMARY KEY(numéro)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_general_ci` ENGINE = MyISAM COMMENT = \'\' ');
        $this->addSql('ALTER TABLE bill DROP FOREIGN KEY FK_7A2119E371179CD6');
        $this->addSql('ALTER TABLE bill DROP FOREIGN KEY FK_7A2119E368D0D14D');
        $this->addSql('ALTER TABLE bill DROP FOREIGN KEY FK_7A2119E3A832C1C9');
        $this->addSql('DROP TABLE bill');
        $this->addSql('DROP INDEX UNIQ_8D93D649E7927C74 ON user');
        $this->addSql('ALTER TABLE user ADD facture INT DEFAULT NULL, CHANGE roles roles VARCHAR(50) DEFAULT NULL, CHANGE password password VARCHAR(10) NOT NULL, CHANGE is_verified is_verified TINYINT(1) DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX `unique` ON user (password)');
    }
}
