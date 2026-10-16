<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261016220556 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE equipe (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, lien_prototype VARCHAR(255) DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE hackathon (id INT AUTO_INCREMENT NOT NULL, date_heure_debut DATETIME NOT NULL, date_heure_fin DATETIME NOT NULL, lieu VARCHAR(100) NOT NULL, ville VARCHAR(50) NOT NULL, theme VARCHAR(100) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE inscription (id INT AUTO_INCREMENT NOT NULL, num INT NOT NULL, date DATE NOT NULL, competence VARCHAR(100) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE organisateur (id INT AUTO_INCREMENT NOT NULL, statut VARCHAR(50) NOT NULL, nom VARCHAR(100) NOT NULL, siteweb VARCHAR(255) DEFAULT NULL, email VARCHAR(150) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE participant (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, email VARCHAR(150) NOT NULL, telephone VARCHAR(20) DEFAULT NULL, date_naissance DATE NOT NULL, lien_portefolio VARCHAR(255) DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE projet (id INT AUTO_INCREMENT NOT NULL, description LONGTEXT NOT NULL, retenu TINYINT NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 (queue_name, available_at, delivered_at, id), PRIMARY KEY (id))');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE equipe');
        $this->addSql('DROP TABLE hackathon');
        $this->addSql('DROP TABLE inscription');
        $this->addSql('DROP TABLE organisateur');
        $this->addSql('DROP TABLE participant');
        $this->addSql('DROP TABLE projet');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
