<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190714110632 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            "INSERT INTO `algorithm` (`code`, `title`) VALUES" .
            " ('AllowAllAllow', 'If All of these conditions are true')" .
            ", ('AllowAnyAllow', 'If Any of these conditions are true')" .
            ", ('DenyAllDeny', 'If All of these conditions are false')" .
            ", ('DenyAnyDeny', 'If Any of these conditions are false')"
        );
        $this->addSql(
            "INSERT INTO `operator` (`code`, `title`) VALUES" .
            " ('IsEqual', 'is equal')" .
            ", ('IsNotEqual', 'is not equal')"
        );
    }

    public function down(Schema $schema): void
    {
        // TODO: Implement down() method.
    }
}
