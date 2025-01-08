<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250108071629 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE installment (id INT AUTO_INCREMENT NOT NULL, repayment_schedule_id INT NOT NULL, number VARCHAR(255) NOT NULL, total_value INT NOT NULL, interest_value INT NOT NULL, principal_value INT NOT NULL, currency VARCHAR(3) NOT NULL, due_date DATE NOT NULL, total_balance_left INT NOT NULL, INDEX IDX_4B778ACD10C4551 (repayment_schedule_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE loan_calculation (id INT AUTO_INCREMENT NOT NULL, total_principal INT NOT NULL, currency VARCHAR(3) NOT NULL, annual_intrest_rate NUMERIC(10, 4) NOT NULL, number_of_payments INT NOT NULL, created_at DATETIME NOT NULL, excluded TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE repayment_schedule (id INT AUTO_INCREMENT NOT NULL, loan_calculation_id INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_DAA993C268EEDD36 (loan_calculation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE installment ADD CONSTRAINT FK_4B778ACD10C4551 FOREIGN KEY (repayment_schedule_id) REFERENCES repayment_schedule (id)');
        $this->addSql('ALTER TABLE repayment_schedule ADD CONSTRAINT FK_DAA993C268EEDD36 FOREIGN KEY (loan_calculation_id) REFERENCES loan_calculation (id)');
   $this->addSql("INSERT INTO user (email, password, roles) VALUES ('user@example.com', '$2y$13$1GuYZjcP2fXkJwC1ME6CuOFjnHK5Imll19uFZzsce7VVDLvwNKiCO', '[\"ROLE_USER\"]')");

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE installment DROP FOREIGN KEY FK_4B778ACD10C4551');
        $this->addSql('ALTER TABLE repayment_schedule DROP FOREIGN KEY FK_DAA993C268EEDD36');
        $this->addSql('DROP TABLE installment');
        $this->addSql('DROP TABLE loan_calculation');
        $this->addSql('DROP TABLE repayment_schedule');
        $this->addSql('DROP TABLE user');
        $this->addSql("DELETE FROM user WHERE email = 'user@example.com'");

    }
}
