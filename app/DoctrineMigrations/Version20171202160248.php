<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171202160248 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user_member_status (user_id INT NOT NULL, member_status_id INT NOT NULL, INDEX IDX_B1584A7FA76ED395 (user_id), INDEX IDX_B1584A7F2BDFD678 (member_status_id), PRIMARY KEY(user_id, member_status_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE member_status_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, male_name VARCHAR(255) NOT NULL, male_description VARCHAR(255) NOT NULL, female_name VARCHAR(255) DEFAULT NULL, female_description VARCHAR(255) DEFAULT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_719B74952C2AC5D3 (translatable_id), UNIQUE INDEX member_status_translation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE member_status (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_member_status ADD CONSTRAINT FK_B1584A7FA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_member_status ADD CONSTRAINT FK_B1584A7F2BDFD678 FOREIGN KEY (member_status_id) REFERENCES member_status (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE member_status_translation ADD CONSTRAINT FK_719B74952C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES member_status (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user_member_status DROP FOREIGN KEY FK_B1584A7F2BDFD678');
        $this->addSql('ALTER TABLE member_status_translation DROP FOREIGN KEY FK_719B74952C2AC5D3');
        $this->addSql('DROP TABLE user_member_status');
        $this->addSql('DROP TABLE member_status_translation');
        $this->addSql('DROP TABLE member_status');
    }
}
