<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240923093757 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE calendar (id INT AUTO_INCREMENT NOT NULL, project_id INT NOT NULL, date DATETIME NOT NULL, type VARCHAR(255) DEFAULT NULL, active TINYINT(1) DEFAULT 0 NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, url VARCHAR(255) DEFAULT NULL, picture_name VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_6EA9A146166D1F9C (project_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formula (id INT AUTO_INCREMENT NOT NULL, format VARCHAR(255) DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gallery (id INT AUTO_INCREMENT NOT NULL, project_id INT NOT NULL, active TINYINT(1) DEFAULT 0 NOT NULL, picture_name VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_472B783A166D1F9C (project_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `member` (id INT AUTO_INCREMENT NOT NULL, bio LONGTEXT DEFAULT NULL, instruments VARCHAR(255) DEFAULT NULL, active TINYINT(1) DEFAULT 0 NOT NULL, lastname VARCHAR(100) NOT NULL, firstname VARCHAR(150) DEFAULT NULL, picture_name VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE member_project (member_id INT NOT NULL, project_id INT NOT NULL, INDEX IDX_9047677A7597D3FE (member_id), INDEX IDX_9047677A166D1F9C (project_id), PRIMARY KEY(member_id, project_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE place (id INT AUTO_INCREMENT NOT NULL, adress VARCHAR(255) NOT NULL, zip_code VARCHAR(5) NOT NULL, city VARCHAR(100) NOT NULL, lastname VARCHAR(100) NOT NULL, firstname VARCHAR(150) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project (id INT AUTO_INCREMENT NOT NULL, style VARCHAR(255) DEFAULT NULL, youtube VARCHAR(255) DEFAULT NULL, presentation LONGTEXT DEFAULT NULL, active TINYINT(1) DEFAULT 0 NOT NULL, email VARCHAR(180) DEFAULT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, picture_name VARCHAR(255) DEFAULT NULL, file_name VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE site (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, logo_name VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, phone VARCHAR(15) DEFAULT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE calendar ADD CONSTRAINT FK_6EA9A146166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE gallery ADD CONSTRAINT FK_472B783A166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE member_project ADD CONSTRAINT FK_9047677A7597D3FE FOREIGN KEY (member_id) REFERENCES `member` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE member_project ADD CONSTRAINT FK_9047677A166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE calendar DROP FOREIGN KEY FK_6EA9A146166D1F9C');
        $this->addSql('ALTER TABLE gallery DROP FOREIGN KEY FK_472B783A166D1F9C');
        $this->addSql('ALTER TABLE member_project DROP FOREIGN KEY FK_9047677A7597D3FE');
        $this->addSql('ALTER TABLE member_project DROP FOREIGN KEY FK_9047677A166D1F9C');
        $this->addSql('DROP TABLE calendar');
        $this->addSql('DROP TABLE formula');
        $this->addSql('DROP TABLE gallery');
        $this->addSql('DROP TABLE `member`');
        $this->addSql('DROP TABLE member_project');
        $this->addSql('DROP TABLE place');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE site');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
