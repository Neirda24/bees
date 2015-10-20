<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151020210425 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE bee (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, max_lifespan INT NOT NULL, remaining_lifespan INT DEFAULT NULL, hit_damages INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_9140CC69727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bee ADD CONSTRAINT FK_9140CC69727ACA70 FOREIGN KEY (parent_id) REFERENCES bee (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE bee DROP FOREIGN KEY FK_9140CC69727ACA70');
        $this->addSql('DROP TABLE bee');
    }
}
