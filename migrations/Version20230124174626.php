<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230124174626 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE api_key (id INT AUTO_INCREMENT NOT NULL, id_usuario INT NOT NULL, token VARCHAR(255) NOT NULL, fecha_expiracion DATETIME NOT NULL, INDEX IDX_C912ED9DFCF8192D (id_usuario), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE api_key ADD CONSTRAINT FK_C912ED9DFCF8192D FOREIGN KEY (id_usuario) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE api_key DROP FOREIGN KEY FK_C912ED9DFCF8192D');
        $this->addSql('DROP TABLE api_key');
    }
}
