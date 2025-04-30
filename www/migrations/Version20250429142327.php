<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250429142327 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE data_type (id INT AUTO_INCREMENT NOT NULL, data_type VARCHAR(25) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE device (id INT AUTO_INCREMENT NOT NULL, room_id INT DEFAULT NULL, label VARCHAR(50) NOT NULL, type VARCHAR(50) NOT NULL, is_active TINYINT(1) NOT NULL, reference VARCHAR(50) NOT NULL, brand VARCHAR(50) NOT NULL, INDEX IDX_92FB68E54177093 (room_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, vibe_id INT NOT NULL, label VARCHAR(25) NOT NULL, date_start DATETIME NOT NULL, date_end DATETIME NOT NULL, INDEX IDX_3BAE0AA74B255BC3 (vibe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE event_room (event_id INT NOT NULL, room_id INT NOT NULL, INDEX IDX_6D541D3071F7E88B (event_id), INDEX IDX_6D541D3054177093 (room_id), PRIMARY KEY(event_id, room_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, image_path VARCHAR(255) NOT NULL, category INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE profile (id INT AUTO_INCREMENT NOT NULL, image_id INT NOT NULL, name VARCHAR(25) NOT NULL, pin_code INT NOT NULL, INDEX IDX_8157AA0F3DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE room (id INT AUTO_INCREMENT NOT NULL, image_id INT DEFAULT NULL, label VARCHAR(25) NOT NULL, UNIQUE INDEX UNIQ_729F519B3DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE setting_data (id INT AUTO_INCREMENT NOT NULL, setting_type_id INT NOT NULL, vibe_id INT NOT NULL, device_id INT NOT NULL, data VARCHAR(25) NOT NULL, INDEX IDX_6C47DF859D1E3C7B (setting_type_id), INDEX IDX_6C47DF854B255BC3 (vibe_id), INDEX IDX_6C47DF8594A4C7D4 (device_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE setting_type (id INT AUTO_INCREMENT NOT NULL, data_type_id INT NOT NULL, label_key VARCHAR(25) NOT NULL, INDEX IDX_4D6A7BCFA147DA62 (data_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE setting_type_device (setting_type_id INT NOT NULL, device_id INT NOT NULL, INDEX IDX_1150AC619D1E3C7B (setting_type_id), INDEX IDX_1150AC6194A4C7D4 (device_id), PRIMARY KEY(setting_type_id, device_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE standard (id INT AUTO_INCREMENT NOT NULL, security INT NOT NULL, energy INT NOT NULL, emotion INT NOT NULL, consciousness INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, roles JSON NOT NULL COMMENT '(DC2Type:json)', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_NAME (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE vibe (id INT AUTO_INCREMENT NOT NULL, profile_id INT NOT NULL, image_id INT NOT NULL, standard_id INT NOT NULL, label VARCHAR(25) NOT NULL, INDEX IDX_42054C01CCFA12B8 (profile_id), INDEX IDX_42054C013DA5256D (image_id), UNIQUE INDEX UNIQ_42054C016F9BFC42 (standard_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE device ADD CONSTRAINT FK_92FB68E54177093 FOREIGN KEY (room_id) REFERENCES room (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA74B255BC3 FOREIGN KEY (vibe_id) REFERENCES vibe (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE event_room ADD CONSTRAINT FK_6D541D3071F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE event_room ADD CONSTRAINT FK_6D541D3054177093 FOREIGN KEY (room_id) REFERENCES room (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE profile ADD CONSTRAINT FK_8157AA0F3DA5256D FOREIGN KEY (image_id) REFERENCES image (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE room ADD CONSTRAINT FK_729F519B3DA5256D FOREIGN KEY (image_id) REFERENCES image (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE setting_data ADD CONSTRAINT FK_6C47DF859D1E3C7B FOREIGN KEY (setting_type_id) REFERENCES setting_type (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE setting_data ADD CONSTRAINT FK_6C47DF854B255BC3 FOREIGN KEY (vibe_id) REFERENCES vibe (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE setting_data ADD CONSTRAINT FK_6C47DF8594A4C7D4 FOREIGN KEY (device_id) REFERENCES device (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE setting_type ADD CONSTRAINT FK_4D6A7BCFA147DA62 FOREIGN KEY (data_type_id) REFERENCES data_type (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE setting_type_device ADD CONSTRAINT FK_1150AC619D1E3C7B FOREIGN KEY (setting_type_id) REFERENCES setting_type (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE setting_type_device ADD CONSTRAINT FK_1150AC6194A4C7D4 FOREIGN KEY (device_id) REFERENCES device (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE vibe ADD CONSTRAINT FK_42054C01CCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE vibe ADD CONSTRAINT FK_42054C013DA5256D FOREIGN KEY (image_id) REFERENCES image (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE vibe ADD CONSTRAINT FK_42054C016F9BFC42 FOREIGN KEY (standard_id) REFERENCES standard (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE device DROP FOREIGN KEY FK_92FB68E54177093
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA74B255BC3
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE event_room DROP FOREIGN KEY FK_6D541D3071F7E88B
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE event_room DROP FOREIGN KEY FK_6D541D3054177093
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE profile DROP FOREIGN KEY FK_8157AA0F3DA5256D
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE room DROP FOREIGN KEY FK_729F519B3DA5256D
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE setting_data DROP FOREIGN KEY FK_6C47DF859D1E3C7B
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE setting_data DROP FOREIGN KEY FK_6C47DF854B255BC3
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE setting_data DROP FOREIGN KEY FK_6C47DF8594A4C7D4
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE setting_type DROP FOREIGN KEY FK_4D6A7BCFA147DA62
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE setting_type_device DROP FOREIGN KEY FK_1150AC619D1E3C7B
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE setting_type_device DROP FOREIGN KEY FK_1150AC6194A4C7D4
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE vibe DROP FOREIGN KEY FK_42054C01CCFA12B8
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE vibe DROP FOREIGN KEY FK_42054C013DA5256D
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE vibe DROP FOREIGN KEY FK_42054C016F9BFC42
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE data_type
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE device
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE event
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE event_room
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE image
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE profile
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE room
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE setting_data
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE setting_type
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE setting_type_device
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE standard
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE `user`
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE vibe
        SQL);
    }
}
