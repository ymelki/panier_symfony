<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220421144928 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE facture (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE mescommandes ADD facture_id INT NOT NULL');
        $this->addSql('ALTER TABLE mescommandes ADD CONSTRAINT FK_220893EA7F2DEE08 FOREIGN KEY (facture_id) REFERENCES facture (id)');
        $this->addSql('CREATE INDEX IDX_220893EA7F2DEE08 ON mescommandes (facture_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mescommandes DROP FOREIGN KEY FK_220893EA7F2DEE08');
        $this->addSql('DROP TABLE facture');
        $this->addSql('DROP INDEX IDX_220893EA7F2DEE08 ON mescommandes');
        $this->addSql('ALTER TABLE mescommandes DROP facture_id');
    }
}
