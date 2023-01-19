<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230119184437 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE adopcion (id INT AUTO_INCREMENT NOT NULL, id_user_id INT NOT NULL, id_animal_id INT NOT NULL, INDEX IDX_2010D98F79F37AE5 (id_user_id), UNIQUE INDEX UNIQ_2010D98FEA39031 (id_animal_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE animales (id INT AUTO_INCREMENT NOT NULL, id_protectora_id INT NOT NULL, tipo VARCHAR(100) NOT NULL, raza VARCHAR(100) NOT NULL, tamano VARCHAR(30) DEFAULT NULL, INDEX IDX_FF62B8DCCFCAA6FB (id_protectora_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE chat (id INT AUTO_INCREMENT NOT NULL, id_emisor_id INT NOT NULL, id_receptor_id INT NOT NULL, cuerpo VARCHAR(255) NOT NULL, fecha_mensaje DATETIME NOT NULL, INDEX IDX_659DF2AAEBEA3BF8 (id_emisor_id), INDEX IDX_659DF2AA207F40F6 (id_receptor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comentarios (id INT AUTO_INCREMENT NOT NULL, id_pub_id INT NOT NULL, id_user_id INT NOT NULL, mensaje VARCHAR(255) NOT NULL, fecha_com DATETIME NOT NULL, INDEX IDX_F54B3FC0A5CA559A (id_pub_id), INDEX IDX_F54B3FC079F37AE5 (id_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE datos_protectora (id INT AUTO_INCREMENT NOT NULL, id_user_id INT NOT NULL, direccion VARCHAR(255) NOT NULL, capacidad INT DEFAULT NULL, logo VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_A7ED177179F37AE5 (id_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE publicaciones (id INT AUTO_INCREMENT NOT NULL, id_user_id INT NOT NULL, imagen VARCHAR(255) DEFAULT NULL, cuerpo VARCHAR(255) NOT NULL, fecha_pub DATETIME NOT NULL, likes INT DEFAULT NULL, INDEX IDX_A3A706C079F37AE5 (id_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rol (id INT AUTO_INCREMENT NOT NULL, tipo VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, id_rol_id INT NOT NULL, username VARCHAR(30) NOT NULL, nombre VARCHAR(50) NOT NULL, apellidos VARCHAR(100) DEFAULT NULL, email VARCHAR(200) NOT NULL, telefono VARCHAR(9) NOT NULL, password VARCHAR(255) NOT NULL, imagen VARCHAR(255) DEFAULT NULL, protectora TINYINT(1) NOT NULL, INDEX IDX_8D93D649228D0C81 (id_rol_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE adopcion ADD CONSTRAINT FK_2010D98F79F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE adopcion ADD CONSTRAINT FK_2010D98FEA39031 FOREIGN KEY (id_animal_id) REFERENCES animales (id)');
        $this->addSql('ALTER TABLE animales ADD CONSTRAINT FK_FF62B8DCCFCAA6FB FOREIGN KEY (id_protectora_id) REFERENCES datos_protectora (id)');
        $this->addSql('ALTER TABLE chat ADD CONSTRAINT FK_659DF2AAEBEA3BF8 FOREIGN KEY (id_emisor_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE chat ADD CONSTRAINT FK_659DF2AA207F40F6 FOREIGN KEY (id_receptor_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE comentarios ADD CONSTRAINT FK_F54B3FC0A5CA559A FOREIGN KEY (id_pub_id) REFERENCES publicaciones (id)');
        $this->addSql('ALTER TABLE comentarios ADD CONSTRAINT FK_F54B3FC079F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE datos_protectora ADD CONSTRAINT FK_A7ED177179F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE publicaciones ADD CONSTRAINT FK_A3A706C079F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649228D0C81 FOREIGN KEY (id_rol_id) REFERENCES rol (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adopcion DROP FOREIGN KEY FK_2010D98F79F37AE5');
        $this->addSql('ALTER TABLE adopcion DROP FOREIGN KEY FK_2010D98FEA39031');
        $this->addSql('ALTER TABLE animales DROP FOREIGN KEY FK_FF62B8DCCFCAA6FB');
        $this->addSql('ALTER TABLE chat DROP FOREIGN KEY FK_659DF2AAEBEA3BF8');
        $this->addSql('ALTER TABLE chat DROP FOREIGN KEY FK_659DF2AA207F40F6');
        $this->addSql('ALTER TABLE comentarios DROP FOREIGN KEY FK_F54B3FC0A5CA559A');
        $this->addSql('ALTER TABLE comentarios DROP FOREIGN KEY FK_F54B3FC079F37AE5');
        $this->addSql('ALTER TABLE datos_protectora DROP FOREIGN KEY FK_A7ED177179F37AE5');
        $this->addSql('ALTER TABLE publicaciones DROP FOREIGN KEY FK_A3A706C079F37AE5');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649228D0C81');
        $this->addSql('DROP TABLE adopcion');
        $this->addSql('DROP TABLE animales');
        $this->addSql('DROP TABLE chat');
        $this->addSql('DROP TABLE comentarios');
        $this->addSql('DROP TABLE datos_protectora');
        $this->addSql('DROP TABLE publicaciones');
        $this->addSql('DROP TABLE rol');
        $this->addSql('DROP TABLE user');
    }
}
