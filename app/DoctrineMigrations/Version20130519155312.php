<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130519155312 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is autogenerated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");
        
        $this->addSql("CREATE TABLE rpg_inventory (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, item_id INT DEFAULT NULL, quantity SMALLINT NOT NULL, itemData LONGTEXT NOT NULL COMMENT '(DC2Type:array)', INDEX IDX_97420E5FA76ED395 (user_id), INDEX IDX_97420E5F126F525E (item_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE rpg_inventory ADD CONSTRAINT FK_97420E5FA76ED395 FOREIGN KEY (user_id) REFERENCES rpg_users (id)");
        $this->addSql("ALTER TABLE rpg_inventory ADD CONSTRAINT FK_97420E5F126F525E FOREIGN KEY (item_id) REFERENCES rpg_items (id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is autogenerated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");
        
        $this->addSql("DROP TABLE rpg_inventory");
    }
}
