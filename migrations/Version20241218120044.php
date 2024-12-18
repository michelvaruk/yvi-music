<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241218120044 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE place ADD title VARCHAR(255) NOT NULL, ADD slug VARCHAR(255) NOT NULL, ADD phone VARCHAR(15) DEFAULT NULL, ADD email VARCHAR(180) DEFAULT NULL, ADD description LONGTEXT DEFAULT NULL, DROP lastname, DROP firstname');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE place ADD lastname VARCHAR(100) NOT NULL, ADD firstname VARCHAR(150) DEFAULT NULL, DROP title, DROP slug, DROP phone, DROP email, DROP description');
    }
}
