<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180725132000 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE confirm_register_code CHANGE user user_id INT NOT NULL');
        $this->addSql('ALTER TABLE confirm_register_code ADD CONSTRAINT FK_35D23C95A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_35D23C95A76ED395 ON confirm_register_code (user_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE confirm_register_code DROP FOREIGN KEY FK_35D23C95A76ED395');
        $this->addSql('DROP INDEX UNIQ_35D23C95A76ED395 ON confirm_register_code');
        $this->addSql('ALTER TABLE confirm_register_code CHANGE user_id user INT NOT NULL');
    }
}
