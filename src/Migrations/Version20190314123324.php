<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190314123324 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, productnumber INT NOT NULL, price INT NOT NULL, image VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_category (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, product_id INT DEFAULT NULL, INDEX IDX_CDFC735612469DE2 (category_id), INDEX IDX_CDFC73564584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shopcard (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, user_id INT DEFAULT NULL, ordereditems_id INT DEFAULT NULL, productnumber INT NOT NULL, INDEX IDX_C88451174584665A (product_id), INDEX IDX_C8845117A76ED395 (user_id), INDEX IDX_C88451172A42DCE2 (ordereditems_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ordered_items (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, adress VARCHAR(100) NOT NULL, paid VARCHAR(255) NOT NULL, phone VARCHAR(50) NOT NULL, city VARCHAR(100) NOT NULL, INDEX IDX_DA06F504A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product_category ADD CONSTRAINT FK_CDFC735612469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE product_category ADD CONSTRAINT FK_CDFC73564584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE shopcard ADD CONSTRAINT FK_C88451174584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE shopcard ADD CONSTRAINT FK_C8845117A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE shopcard ADD CONSTRAINT FK_C88451172A42DCE2 FOREIGN KEY (ordereditems_id) REFERENCES ordered_items (id)');
        $this->addSql('ALTER TABLE ordered_items ADD CONSTRAINT FK_DA06F504A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE product_category DROP FOREIGN KEY FK_CDFC73564584665A');
        $this->addSql('ALTER TABLE shopcard DROP FOREIGN KEY FK_C88451174584665A');
        $this->addSql('ALTER TABLE shopcard DROP FOREIGN KEY FK_C8845117A76ED395');
        $this->addSql('ALTER TABLE ordered_items DROP FOREIGN KEY FK_DA06F504A76ED395');
        $this->addSql('ALTER TABLE shopcard DROP FOREIGN KEY FK_C88451172A42DCE2');
        $this->addSql('ALTER TABLE product_category DROP FOREIGN KEY FK_CDFC735612469DE2');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE product_category');
        $this->addSql('DROP TABLE shopcard');
        $this->addSql('DROP TABLE ordered_items');
        $this->addSql('DROP TABLE category');
    }
}