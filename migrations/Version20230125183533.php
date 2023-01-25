<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230125183533 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE adopcion (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, animal_id INT NOT NULL, INDEX IDX_2010D98FA76ED395 (user_id), UNIQUE INDEX UNIQ_2010D98F8E962C16 (animal_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE animales (id INT AUTO_INCREMENT NOT NULL, tipo VARCHAR(255) NOT NULL, raza VARCHAR(255) NOT NULL, tamano VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE asociaciones (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, direccion VARCHAR(255) NOT NULL, capacidad INT NOT NULL, logo VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_E24D1A74A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE chat (id INT AUTO_INCREMENT NOT NULL, emisor_id INT NOT NULL, receptor_id INT NOT NULL, cuerpo VARCHAR(255) NOT NULL, fecha DATETIME NOT NULL, INDEX IDX_659DF2AA6BDF87DF (emisor_id), INDEX IDX_659DF2AA386D8D01 (receptor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comentarios (id INT AUTO_INCREMENT NOT NULL, publicacion_id INT NOT NULL, user_id INT NOT NULL, mensaje VARCHAR(255) NOT NULL, fecha_com DATETIME NOT NULL, INDEX IDX_F54B3FC09ACBB5E7 (publicacion_id), INDEX IDX_F54B3FC0A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE publicaciones (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, cuerpo VARCHAR(255) NOT NULL, fecha_pub DATETIME NOT NULL, likes INT DEFAULT NULL, imagen VARCHAR(255) DEFAULT NULL, INDEX IDX_A3A706C0A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE adopcion ADD CONSTRAINT FK_2010D98FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE adopcion ADD CONSTRAINT FK_2010D98F8E962C16 FOREIGN KEY (animal_id) REFERENCES animales (id)');
        $this->addSql('ALTER TABLE asociaciones ADD CONSTRAINT FK_E24D1A74A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE chat ADD CONSTRAINT FK_659DF2AA6BDF87DF FOREIGN KEY (emisor_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE chat ADD CONSTRAINT FK_659DF2AA386D8D01 FOREIGN KEY (receptor_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE comentarios ADD CONSTRAINT FK_F54B3FC09ACBB5E7 FOREIGN KEY (publicacion_id) REFERENCES publicaciones (id)');
        $this->addSql('ALTER TABLE comentarios ADD CONSTRAINT FK_F54B3FC0A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE publicaciones ADD CONSTRAINT FK_A3A706C0A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adopcion DROP FOREIGN KEY FK_2010D98FA76ED395');
        $this->addSql('ALTER TABLE adopcion DROP FOREIGN KEY FK_2010D98F8E962C16');
        $this->addSql('ALTER TABLE asociaciones DROP FOREIGN KEY FK_E24D1A74A76ED395');
        $this->addSql('ALTER TABLE chat DROP FOREIGN KEY FK_659DF2AA6BDF87DF');
        $this->addSql('ALTER TABLE chat DROP FOREIGN KEY FK_659DF2AA386D8D01');
        $this->addSql('ALTER TABLE comentarios DROP FOREIGN KEY FK_F54B3FC09ACBB5E7');
        $this->addSql('ALTER TABLE comentarios DROP FOREIGN KEY FK_F54B3FC0A76ED395');
        $this->addSql('ALTER TABLE publicaciones DROP FOREIGN KEY FK_A3A706C0A76ED395');
        $this->addSql('DROP TABLE adopcion');
        $this->addSql('DROP TABLE animales');
        $this->addSql('DROP TABLE asociaciones');
        $this->addSql('DROP TABLE chat');
        $this->addSql('DROP TABLE comentarios');
        $this->addSql('DROP TABLE publicaciones');
    }
}
