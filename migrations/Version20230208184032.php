<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230208184032 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tags (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tags_publicaciones (tags_id INT NOT NULL, publicaciones_id INT NOT NULL, INDEX IDX_5F4DEA408D7B4FB4 (tags_id), INDEX IDX_5F4DEA40E906C21E (publicaciones_id), PRIMARY KEY(tags_id, publicaciones_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tags_publicaciones ADD CONSTRAINT FK_5F4DEA408D7B4FB4 FOREIGN KEY (tags_id) REFERENCES tags (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tags_publicaciones ADD CONSTRAINT FK_5F4DEA40E906C21E FOREIGN KEY (publicaciones_id) REFERENCES publicaciones (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tags_publicaciones DROP FOREIGN KEY FK_5F4DEA408D7B4FB4');
        $this->addSql('ALTER TABLE tags_publicaciones DROP FOREIGN KEY FK_5F4DEA40E906C21E');
        $this->addSql('DROP TABLE tags');
        $this->addSql('DROP TABLE tags_publicaciones');
    }
}
