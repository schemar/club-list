<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171214192926 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE invitation (code VARCHAR(6) NOT NULL, email VARCHAR(256) NOT NULL, locale VARCHAR(2) NOT NULL, sent TINYINT(1) NOT NULL, PRIMARY KEY(code)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user ADD invitation_id VARCHAR(6) DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649A35D7AF0 FOREIGN KEY (invitation_id) REFERENCES invitation (code)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649A35D7AF0 ON user (invitation_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649A35D7AF0');
        $this->addSql('DROP TABLE invitation');
        $this->addSql('DROP INDEX UNIQ_8D93D649A35D7AF0 ON `user`');
        $this->addSql('ALTER TABLE `user` DROP invitation_id');
    }
}
