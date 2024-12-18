<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240924215313 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE project_member (project_id INT NOT NULL, member_id INT NOT NULL, INDEX IDX_67401132166D1F9C (project_id), INDEX IDX_674011327597D3FE (member_id), PRIMARY KEY(project_id, member_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE project_member ADD CONSTRAINT FK_67401132166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE project_member ADD CONSTRAINT FK_674011327597D3FE FOREIGN KEY (member_id) REFERENCES `member` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE member_project DROP FOREIGN KEY FK_9047677A166D1F9C');
        $this->addSql('ALTER TABLE member_project DROP FOREIGN KEY FK_9047677A7597D3FE');
        $this->addSql('DROP TABLE member_project');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE member_project (member_id INT NOT NULL, project_id INT NOT NULL, INDEX IDX_9047677A7597D3FE (member_id), INDEX IDX_9047677A166D1F9C (project_id), PRIMARY KEY(member_id, project_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE member_project ADD CONSTRAINT FK_9047677A166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE member_project ADD CONSTRAINT FK_9047677A7597D3FE FOREIGN KEY (member_id) REFERENCES `member` (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE project_member DROP FOREIGN KEY FK_67401132166D1F9C');
        $this->addSql('ALTER TABLE project_member DROP FOREIGN KEY FK_674011327597D3FE');
        $this->addSql('DROP TABLE project_member');
    }
}
