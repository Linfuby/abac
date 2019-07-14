<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190714110631 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql',
            'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE operator (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE algorithm (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE conditions (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, attribute VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rule_set (id INT AUTO_INCREMENT NOT NULL, target_id INT NOT NULL, algorithm_id INT NOT NULL, title VARCHAR(255) NOT NULL, INDEX IDX_91D8622E158E0B66 (target_id), INDEX IDX_91D8622EBBEB6CF7 (algorithm_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rule_set_rule (rule_set_id INT NOT NULL, rule_id INT NOT NULL, INDEX IDX_1FE3ADE98B51FD88 (rule_set_id), INDEX IDX_1FE3ADE9744E0351 (rule_id), PRIMARY KEY(rule_set_id, rule_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE target (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, attribute VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rule (id INT AUTO_INCREMENT NOT NULL, target_id INT NOT NULL, algorithm_id INT NOT NULL, title VARCHAR(255) NOT NULL, INDEX IDX_46D8ACCC158E0B66 (target_id), INDEX IDX_46D8ACCCBBEB6CF7 (algorithm_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rule_condition (rule_id INT NOT NULL, condition_id INT NOT NULL, INDEX IDX_627A9B63744E0351 (rule_id), INDEX IDX_627A9B63887793B6 (condition_id), PRIMARY KEY(rule_id, condition_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE rule_set ADD CONSTRAINT FK_91D8622E158E0B66 FOREIGN KEY (target_id) REFERENCES target (id)');
        $this->addSql('ALTER TABLE rule_set ADD CONSTRAINT FK_91D8622EBBEB6CF7 FOREIGN KEY (algorithm_id) REFERENCES algorithm (id)');
        $this->addSql('ALTER TABLE rule_set_rule ADD CONSTRAINT FK_1FE3ADE98B51FD88 FOREIGN KEY (rule_set_id) REFERENCES rule_set (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rule_set_rule ADD CONSTRAINT FK_1FE3ADE9744E0351 FOREIGN KEY (rule_id) REFERENCES rule (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rule ADD CONSTRAINT FK_46D8ACCC158E0B66 FOREIGN KEY (target_id) REFERENCES target (id)');
        $this->addSql('ALTER TABLE rule ADD CONSTRAINT FK_46D8ACCCBBEB6CF7 FOREIGN KEY (algorithm_id) REFERENCES algorithm (id)');
        $this->addSql('ALTER TABLE rule_condition ADD CONSTRAINT FK_627A9B63744E0351 FOREIGN KEY (rule_id) REFERENCES rule (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rule_condition ADD CONSTRAINT FK_627A9B63887793B6 FOREIGN KEY (condition_id) REFERENCES conditions (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql',
            'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE rule_set DROP FOREIGN KEY FK_91D8622EBBEB6CF7');
        $this->addSql('ALTER TABLE rule DROP FOREIGN KEY FK_46D8ACCCBBEB6CF7');
        $this->addSql('ALTER TABLE rule_condition DROP FOREIGN KEY FK_627A9B63887793B6');
        $this->addSql('ALTER TABLE rule_set_rule DROP FOREIGN KEY FK_1FE3ADE98B51FD88');
        $this->addSql('ALTER TABLE rule_set DROP FOREIGN KEY FK_91D8622E158E0B66');
        $this->addSql('ALTER TABLE rule DROP FOREIGN KEY FK_46D8ACCC158E0B66');
        $this->addSql('ALTER TABLE rule_set_rule DROP FOREIGN KEY FK_1FE3ADE9744E0351');
        $this->addSql('ALTER TABLE rule_condition DROP FOREIGN KEY FK_627A9B63744E0351');
        $this->addSql('DROP TABLE algorithm');
        $this->addSql('DROP TABLE operator');
        $this->addSql('DROP TABLE conditions');
        $this->addSql('DROP TABLE rule_set');
        $this->addSql('DROP TABLE rule_set_rule');
        $this->addSql('DROP TABLE target');
        $this->addSql('DROP TABLE rule');
        $this->addSql('DROP TABLE rule_condition');
    }
}
