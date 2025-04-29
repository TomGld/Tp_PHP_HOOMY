<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250428095624 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE setting_data DROP INDEX UNIQ_6C47DF8594A4C7D4, ADD INDEX IDX_6C47DF8594A4C7D4 (device_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE setting_data CHANGE device_id device_id INT NOT NULL
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE setting_data DROP INDEX IDX_6C47DF8594A4C7D4, ADD UNIQUE INDEX UNIQ_6C47DF8594A4C7D4 (device_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE setting_data CHANGE device_id device_id INT DEFAULT NULL
        SQL);
    }
}
