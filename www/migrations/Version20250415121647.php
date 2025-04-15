<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250415121647 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE room_vibe (room_id INT NOT NULL, vibe_id INT NOT NULL, INDEX IDX_2101A66554177093 (room_id), INDEX IDX_2101A6654B255BC3 (vibe_id), PRIMARY KEY(room_id, vibe_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE room_vibe ADD CONSTRAINT FK_2101A66554177093 FOREIGN KEY (room_id) REFERENCES room (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE room_vibe ADD CONSTRAINT FK_2101A6654B255BC3 FOREIGN KEY (vibe_id) REFERENCES vibe (id) ON DELETE CASCADE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE room_vibe DROP FOREIGN KEY FK_2101A66554177093
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE room_vibe DROP FOREIGN KEY FK_2101A6654B255BC3
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE room_vibe
        SQL);
    }
}
