<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211014160135 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Liaison des tables';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE employees ADD job_id INT NOT NULL');
        $this->addSql('ALTER TABLE employees ADD CONSTRAINT FK_BA82C300BE04EA9 FOREIGN KEY (job_id) REFERENCES jobs (id)');
        $this->addSql('CREATE INDEX IDX_BA82C300BE04EA9 ON employees (job_id)');
        $this->addSql('ALTER TABLE pausetimes ADD task_id INT NOT NULL');
        $this->addSql('ALTER TABLE pausetimes ADD CONSTRAINT FK_E427AA338DB60186 FOREIGN KEY (task_id) REFERENCES tasks (id)');
        $this->addSql('CREATE INDEX IDX_E427AA338DB60186 ON pausetimes (task_id)');
        $this->addSql('ALTER TABLE tasks ADD employee_id INT NOT NULL');
        $this->addSql('ALTER TABLE tasks ADD CONSTRAINT FK_505865978C03F15C FOREIGN KEY (employee_id) REFERENCES employees (id)');
        $this->addSql('CREATE INDEX IDX_505865978C03F15C ON tasks (employee_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE employees DROP FOREIGN KEY FK_BA82C300BE04EA9');
        $this->addSql('DROP INDEX IDX_BA82C300BE04EA9 ON employees');
        $this->addSql('ALTER TABLE employees DROP job_id');
        $this->addSql('ALTER TABLE pausetimes DROP FOREIGN KEY FK_E427AA338DB60186');
        $this->addSql('DROP INDEX IDX_E427AA338DB60186 ON pausetimes');
        $this->addSql('ALTER TABLE pausetimes DROP task_id');
        $this->addSql('ALTER TABLE tasks DROP FOREIGN KEY FK_505865978C03F15C');
        $this->addSql('DROP INDEX IDX_505865978C03F15C ON tasks');
        $this->addSql('ALTER TABLE tasks DROP employee_id');
    }
}
