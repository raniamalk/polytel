<?php declare(strict_types=1);

namespace Sylius\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181221122852 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE infocontact (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, fax VARCHAR(255) NOT NULL, facebook VARCHAR(255) NOT NULL, linkedin VARCHAR(255) NOT NULL, instagram VARCHAR(255) DEFAULT NULL, youtube VARCHAR(255) DEFAULT NULL, metadescription LONGTEXT NOT NULL, metakeywords LONGTEXT NOT NULL, path VARCHAR(255) DEFAULT NULL, patha VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sylius_product_review CHANGE title title VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE infocontact');
        $this->addSql('ALTER TABLE sylius_product_review CHANGE title title VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
    }
}
