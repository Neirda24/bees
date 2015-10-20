<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151020220106 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, queen_bee_id INT NOT NULL, number_round INT NOT NULL, INDEX IDX_232B318CFB9F9832 (queen_bee_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318CFB9F9832 FOREIGN KEY (queen_bee_id) REFERENCES bee (id)');
        $this->addSql('ALTER TABLE bee DROP FOREIGN KEY FK_9140CC69727ACA70');
        $this->addSql('DROP INDEX IDX_9140CC69727ACA70 ON bee');
        $this->addSql('ALTER TABLE bee ADD bee_type VARCHAR(255) NOT NULL, CHANGE parent_id queen_bee_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bee ADD CONSTRAINT FK_9140CC69FB9F9832 FOREIGN KEY (queen_bee_id) REFERENCES bee (id)');
        $this->addSql('CREATE INDEX IDX_9140CC69FB9F9832 ON bee (queen_bee_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE game');
        $this->addSql('ALTER TABLE bee DROP FOREIGN KEY FK_9140CC69FB9F9832');
        $this->addSql('DROP INDEX IDX_9140CC69FB9F9832 ON bee');
        $this->addSql('ALTER TABLE bee DROP bee_type, CHANGE queen_bee_id parent_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bee ADD CONSTRAINT FK_9140CC69727ACA70 FOREIGN KEY (parent_id) REFERENCES bee (id)');
        $this->addSql('CREATE INDEX IDX_9140CC69727ACA70 ON bee (parent_id)');
    }
}
