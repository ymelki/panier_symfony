<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220420132233 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE mescommandes (id INT AUTO_INCREMENT NOT NULL, produits_id INT NOT NULL, quantite INT NOT NULL, total INT NOT NULL, INDEX IDX_220893EACD11A2CF (produits_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE mescommandes ADD CONSTRAINT FK_220893EACD11A2CF FOREIGN KEY (produits_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE produit RENAME INDEX fk_29a5ec27a21214b7 TO IDX_29A5EC27A21214B7');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE mescommandes');
        $this->addSql('ALTER TABLE produit RENAME INDEX idx_29a5ec27a21214b7 TO FK_29A5EC27A21214B7');
    }
}
