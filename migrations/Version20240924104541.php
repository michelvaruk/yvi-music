<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240924104541 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE calendar ADD place_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE calendar ADD CONSTRAINT FK_6EA9A146DA6A219 FOREIGN KEY (place_id) REFERENCES place (id)');
        $this->addSql('CREATE INDEX IDX_6EA9A146DA6A219 ON calendar (place_id)');
        $this->addSql('ALTER TABLE formula ADD project_id INT NOT NULL');
        $this->addSql('ALTER TABLE formula ADD CONSTRAINT FK_67315881166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('CREATE INDEX IDX_67315881166D1F9C ON formula (project_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE calendar DROP FOREIGN KEY FK_6EA9A146DA6A219');
        $this->addSql('DROP INDEX IDX_6EA9A146DA6A219 ON calendar');
        $this->addSql('ALTER TABLE calendar DROP place_id');
        $this->addSql('ALTER TABLE formula DROP FOREIGN KEY FK_67315881166D1F9C');
        $this->addSql('DROP INDEX IDX_67315881166D1F9C ON formula');
        $this->addSql('ALTER TABLE formula DROP project_id');
    }
}
