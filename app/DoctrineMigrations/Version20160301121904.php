<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160301121904 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE SimpleGroupUsers (simpleuser_id INT NOT NULL, simplegroup_id INT NOT NULL, INDEX IDX_B984376AC8E68E72 (simpleuser_id), INDEX IDX_B984376AC05526C1 (simplegroup_id), PRIMARY KEY(simpleuser_id, simplegroup_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE SimpleGroupUsers ADD CONSTRAINT FK_B984376AC8E68E72 FOREIGN KEY (simpleuser_id) REFERENCES SimpleUsers (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE SimpleGroupUsers ADD CONSTRAINT FK_B984376AC05526C1 FOREIGN KEY (simplegroup_id) REFERENCES SimpleGroups (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE ProjectGithubRepos');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE ProjectGithubRepos (simpleuser_id INT NOT NULL, simplegroup_id INT NOT NULL, INDEX IDX_FB337D6EC8E68E72 (simpleuser_id), INDEX IDX_FB337D6EC05526C1 (simplegroup_id), PRIMARY KEY(simpleuser_id, simplegroup_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ProjectGithubRepos ADD CONSTRAINT FK_FB337D6EC05526C1 FOREIGN KEY (simplegroup_id) REFERENCES SimpleGroups (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ProjectGithubRepos ADD CONSTRAINT FK_FB337D6EC8E68E72 FOREIGN KEY (simpleuser_id) REFERENCES SimpleUsers (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE SimpleGroupUsers');
    }
}
